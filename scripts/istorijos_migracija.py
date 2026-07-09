import os
import re
import csv
import json
from collections import defaultdict
from datetime import datetime

SQL_FILE = '../wp-docs/sviesiai_wp2_1783611747.sql'
OUTPUT_CSV = '../data/istoriniai_duomenys.csv'
OUTPUT_JSON = '../data/istoriniai_duomenys.json'

def parse_sql_dump():
    submissions = defaultdict(dict)
    
    # Regex to extract VALUES(...) from the INSERT statement
    # The structure is: (submit_time, 'form_name', 'field_name', 'field_value', field_order, file)
    # We will use a regex that matches the tuples
    
    # Since values can contain quotes and commas, a simple regex might break on complex 'field_value'.
    # A more robust approach is needed if values contain string escapes.
    # However, let's try a regex for the standard format first.
    tuple_pattern = re.compile(r"\(([\d\.]+),'([^']+)','([^']+)','(.*?)',(\d+),(NULL|'[^']*')\)")
    
    if not os.path.exists(SQL_FILE):
        print(f"File not found: {SQL_FILE}")
        return
        
    print(f"Reading {SQL_FILE}...")
    with open(SQL_FILE, 'r', encoding='utf-8', errors='ignore') as f:
        for line in f:
            if "INSERT INTO `wp_cf7dbplugin_submits`" in line:
                # The line contains all the tuples
                # We need to split by `),(` but we must be careful with commas inside strings.
                # Actually, the tuple_pattern regex might just work with findall if we are careful.
                # Let's write a small parser.
                
                # Strip the `INSERT INTO ... VALUES ` part
                start_idx = line.find(' VALUES ')
                if start_idx == -1: continue
                values_str = line[start_idx + 8:].strip()
                if values_str.endswith(';'): values_str = values_str[:-1]
                
                # A simple state machine to parse the tuples
                in_string = False
                escape_next = False
                current_tuple = []
                current_val = ""
                
                i = 0
                while i < len(values_str):
                    char = values_str[i]
                    
                    if escape_next:
                        current_val += char
                        escape_next = False
                    elif char == '\\':
                        escape_next = True
                    elif char == "'":
                        in_string = not in_string
                    elif char == ',' and not in_string:
                        current_tuple.append(current_val)
                        current_val = ""
                    elif char == '(' and not in_string:
                        current_tuple = []
                        current_val = ""
                    elif char == ')' and not in_string:
                        current_tuple.append(current_val)
                        # Process tuple
                        if len(current_tuple) == 6:
                            submit_time = current_tuple[0].strip()
                            form_name = current_tuple[1].strip("'")
                            field_name = current_tuple[2].strip("'")
                            field_value = current_tuple[3]
                            if field_value.startswith("'") and field_value.endswith("'"):
                                field_value = field_value[1:-1]
                            
                            # Clean up escaped quotes
                            field_value = field_value.replace("\\'", "'").replace('\\"', '"').replace('\\n', '\n').replace('\\r', '\r')
                            
                            # Group by submit_time
                            submissions[submit_time]['submit_time'] = submit_time
                            submissions[submit_time]['form_name'] = form_name
                            
                            # Format date
                            try:
                                ts = float(submit_time)
                                dt = datetime.fromtimestamp(ts)
                                submissions[submit_time]['date'] = dt.strftime('%Y-%m-%d %H:%M:%S')
                            except:
                                submissions[submit_time]['date'] = submit_time
                            
                            submissions[submit_time][field_name] = field_value
                            
                        current_val = ""
                    else:
                        current_val += char
                    
                    i += 1

    print(f"Extracted {len(submissions)} form submissions.")
    
    # Write to JSON
    with open(OUTPUT_JSON, 'w', encoding='utf-8') as f:
        json.dump(list(submissions.values()), f, ensure_ascii=False, indent=2)
    print(f"Saved to {OUTPUT_JSON}")
    
    # Write to CSV
    # Collect all possible headers
    headers = set()
    for sub in submissions.values():
        headers.update(sub.keys())
        
    # Standardize header order
    ordered_headers = ['date', 'submit_time', 'form_name', 'your-name', 'your-email', 'your-phone', 'your-message', 'Submitted From']
    final_headers = ordered_headers + [h for h in headers if h not in ordered_headers]
    
    with open(OUTPUT_CSV, 'w', encoding='utf-8', newline='') as f:
        writer = csv.DictWriter(f, fieldnames=final_headers)
        writer.writeheader()
        for sub in submissions.values():
            writer.writerow(sub)
    print(f"Saved to {OUTPUT_CSV}")

if __name__ == '__main__':
    # Create data dir if not exists
    os.makedirs('../data', exist_ok=True)
    parse_sql_dump()
