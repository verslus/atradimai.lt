<!-- =========================
 SECTION: SERVICES
============================== -->
<?php
	global $wp_customize;
	$parallax_one_our_services_title = get_theme_mod('parallax_one_our_services_title','What');
	$parallax_one_our_services_subtitle = get_theme_mod('parallax_one_our_services_subtitle','Lorem ipsum dolor sit amet, consectetur adipiscing elit.');
	$parallax_one_services = get_theme_mod('parallax_one_services_content',
		json_encode(
			array(
					array('choice'=>'parallax_icon','icon_value' => 'icon-basic-webpage-multiple','title' => esc_html__('STRENGTHS','parallax-one'),'text' => esc_html__('Identify your strengths, pinpoint your talents and define your success pattern.','parallax-one')),
					array('choice'=>'parallax_icon','icon_value' => 'icon-ecommerce-graph3','title' => esc_html__('MOTIVATION','parallax-one'),'text' => esc_html__('Understand your inner needs, learn what tasks and environment motivate you most, what is your biggest motivational force.','parallax-one')),
					array('choice'=>'parallax_icon','icon_value' => 'icon-basic-geolocalize-05','title' => esc_html__('ACTION','parallax-one'),'text' => esc_html__('Learn how to put your strengths and motivations to action and direct them to fulfilling career path.','parallax-one'))
			)
		)
	);

	if(!empty($parallax_one_our_services_title) || !empty($parallax_one_our_services_subtitle) || !parallax_one_general_repeater_is_empty($parallax_one_services)){
?>
		<section class="services" id="services" role="region" aria-label="<?php esc_html_e('Services','parallax-one') ?>">
			<div class="section-overlay-layer">
				<div class="container">

					<!-- SECTION HEADER -->
<span id="bazinga"></span>
					<div class="section-header">
						<?php
							if( !empty($parallax_one_our_services_title) ){
								echo '<h2 class="dark-text">'.esc_attr($parallax_one_our_services_title).'</h2><div class="colored-line"></div>';
							} elseif ( isset( $wp_customize )   ) {
								echo '<h2 class="dark-text paralax_one_only_customizer"></h2><div class="colored-line paralax_one_only_customizer"></div>';
							}
						?>

						<?php
							if( !empty($parallax_one_our_services_subtitle) ){
								echo '<div class="sub-heading">Hi! So probably you’re one who is slightly confused, slightly unhappy and slightly fogged about your career path. Don’t worry, you are not alone in this and we are happy you joined us on this boat - Self Columbus! </br>
It’s a <b>7-week individual online program </b>which helps you discover and better understand <b>your professional potential</b>.</div>';
							} elseif ( isset( $wp_customize )   ) {
								echo '<div class="sub-heading paralax_one_only_customizer"></div>';
							}
						?>
					</div>


					<?php
						if( !empty($parallax_one_services) ){
							$parallax_one_services_decoded = json_decode($parallax_one_services);
							echo '<div id="our_services_wrap" class="services-wrap">';
								foreach($parallax_one_services_decoded as $parallax_one_service_box){
									if( (!empty($parallax_one_service_box->icon_value) && $parallax_one_service_box->icon_value!='No Icon' && $parallax_one_service_box->choice == 'parallax_icon')  || (!empty($parallax_one_service_box->image_url)  && $parallax_one_service_box->choice == 'parallax_image') || !empty($parallax_one_service_box->title) || !empty($parallax_one_service_box->text) ){
										echo '<div class="service-box"><div class="single-service border-bottom-hover">';
											if( !empty($parallax_one_service_box->choice) && $parallax_one_service_box->choice !== 'parallax_none'  ){
												if ( $parallax_one_service_box->choice == 'parallax_icon' ){
													if( !empty($parallax_one_service_box->icon_value) ) {
														if( !empty($parallax_one_service_box->link) ){
															echo '<div class="service-icon colored-text"><a href="'.esc_url($parallax_one_service_box->link).'"><img src="http://selfcolumbus.com/wp-content/uploads/2015/10/icon3.png"></a></div>';
														} else {
															echo '<div class="service-icon colored-text"><span class="'.esc_attr($parallax_one_service_box->icon_value).'"></span></div>';
														}
													}
												}
												if( $parallax_one_service_box->choice == 'parallax_image' ){
													if( !empty($parallax_one_service_box->image_url)){
														if( !empty($parallax_one_service_box->link) ){
															if(!empty($parallax_one_service_box->title)){
																echo '<a href="'.esc_url($parallax_one_service_box->link).'"><img src="'.esc_url($parallax_one_service_box->image_url).'" alt="'.$parallax_one_service_box->title.'"/></a>';
															} else {
																echo '<a href="'.esc_url($parallax_one_service_box->link).'"><img src="'.esc_url($parallax_one_service_box->image_url).'" alt="'.esc_html__('Featured Image','parallax-one').'"/></a>';
															}
														} else {
															if(!empty($parallax_one_service_box->title)){
																echo '<img src="'.esc_url($parallax_one_service_box->image_url).'" alt="'.$parallax_one_service_box->title.'"/>';
															} else {
																echo '<img src="'.esc_url($parallax_one_service_box->image_url).'" alt="'.esc_html__('Featured Image','parallax-one').'"/>';
															}
														}
													}
												}
											}
											if(!empty($parallax_one_service_box->title)){
												if( !empty($parallax_one_service_box->link) ){
													if (function_exists ( 'icl_translate' ) && !empty($parallax_one_service_box->id)){
														$parallax_one_title_services = icl_translate('Featured Area',$parallax_one_service_box->id.'_services_title',$parallax_one_service_box->title);
														echo '<h3 class="colored-text"><a href="'.esc_url($parallax_one_service_box->link).'">'.esc_attr($parallax_one_title_services).'</a></h3>';
													} else {
														echo '<h3 class="colored-text"><a href="'.esc_url($parallax_one_service_box->link).'">'.esc_attr($parallax_one_service_box->title).'</a></h3>';
													}
												} else {
													if (function_exists ( 'icl_translate' ) && !empty($parallax_one_service_box->id)){
														$parallax_one_title_services = icl_translate('Featured Area',$parallax_one_service_box->id.'_services_title',$parallax_one_service_box->title);
														echo '<h3 class="colored-text">'.esc_attr($parallax_one_title_services).'</h3>';
													} else {
														echo '<h3 class="colored-text">'.esc_attr($parallax_one_service_box->title).'</h3>';
													}
												}
											}
											if(!empty($parallax_one_service_box->text)){
												if (function_exists ( 'icl_translate' ) && !empty($parallax_one_service_box->id)){
													echo '<p>'.icl_translate('Featured Area',$parallax_one_service_box->id.'_services_text',$parallax_one_service_box->text).'</p>';
												} else {
													echo '<p>'.$parallax_one_service_box->text.'</p>';
												}
											}
										echo '</div></div>';
									}
								}
							echo '</div>';
						}
					?>
				</div>	
			</div>
		</section>
<?php
	} else {
		if( isset( $wp_customize ) ) {
?>
			<section class="services paralax_one_only_customizer" id="services" role="region" aria-label="<?php esc_html_e('Services','parallax-one') ?>">
				<div class="section-overlay-layer">
					<div class="container">
						<div class="section-header">
							<h2 class="dark-text paralax_one_only_customizer"></h2><div class="colored-line paralax_one_only_customizer"></div>
							<div class="sub-heading paralax_one_only_customizer"></div>
						</div>
					</div>
				</div>
			</section>
<?php
		}
	}
?>