<?php

if ( 'posts' == get_option( 'show_on_front' ) ) {
	
		get_header(); 

		parallax_one_get_template_part( apply_filters("parallax_one_plus_header_layout","/sections/parallax_one_header_section"));
	?>
		</div>
		<!-- /END COLOR OVER IMAGE -->
	</header>
	<!-- /END HOME / HEADER  -->

	<div itemprop id="content" class="content-warp" role="main">

	
<section class="services" id="services" role="region" aria-label="Services">


<div class="container">
<span id="what"></span>
	

	<div class="section-header">
		<h2 class="dark-text">Kodėl tai svarbu?</h2>
		<div class="colored-line"></div>
</div>
	<div class="container narrow">
		<center><p>
			Mes turime tūkstančius kartų daugiau galimybių nei mūsų tėvai ar seneliai. 
Mes turime daug daugiau laisvės, tačiau kartu su ja – ir atsakomybės. </br>
Nuo mūsų pačių priklauso, kiek mes pasinaudosime mums atitekusiomis galimybėmis, kiek pasieksime gyvenime ir kokie laimingi būsime.</p>

<p>Atradimai.lt – <b>7 savaičių nuotolinė programa</b>, skirta suprasti, kur tu esi geriausias, kokie tavo vidiniai norai ir <b>kaip išmokti panaudoti savo potencialą</b>.
		</p></center>
	
</div>
	<div>
		<div class="col-md-4">
			<div class="service-box" parallax_onegrid-attr="this-1">
				<div class="single-service border-bottom-hover">
					<div class="service-icon colored-text">
						<img src="http://atradimai.lt/wp-content/uploads/2015/10/vairas_pilkas_strengths.png" width="130px">
					</div>
					<h3 class="colored-text">Stipriosios pusės</h3>
					<p>Aukščiausių rezultatų gali pasiekti darydamas tai, ką moki geriausiai. Ar tu žinai savo stipriąsias puses? Surask atsakymą į šį klausimą!</p>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="service-box" parallax_onegrid-attr="this-1">
				<div class="single-service border-bottom-hover">
					<div class="service-icon colored-text">
						<img src="http://atradimai.lt/wp-content/uploads/2015/10/pilkas_motivations-copy_2.png" width="130px">
					</div>
					<h3 class="colored-text">Motyvacija</h3>
					<p>Pergalėms pasiekti reikia daug vidinės energijos, kuri kyla iš motyvacijos. Atrask savo motyvacijos šaltinį ir išmok save motyvuoti!
</p>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="service-box" parallax_onegrid-attr="this-1">
				<div class="single-service border-bottom-hover">
					<div class="service-icon colored-text">
						<img src="http://atradimai.lt/wp-content/uploads/2015/10/laivvas_pilkas_action.png" width="130px">
					</div>
					<h3 class="colored-text">Augimas</h3>
					<p>Suformuok įpročius, kurie padės tau geriau save pažinti, nuolatos augti bei ugdytis reikalingas kompetencijas.</p>
				</div>
			</div>
		</div>
	</div>

</div>

	</div></div></div>
	<!-- Modal -->
		<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
 			 <div class="modal-dialog" role="document">
    				<div class="modal-content">
      					<div class="modal-header">
        					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        					<h4 class="modal-title" id="myModalLabel">Prenumeruoti naujienas</h4>
      					</div>
      					<div class="modal-body">
        					<?php echo do_shortcode('[contact-form-7 id="747" title="Prenumeruoti"]');?>
      					</div>
     
    				</div>
  			</div>
		</div>
	<!-- Modal -->
		<div class="modal fade" id="myModal5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
 			 <div class="modal-dialog" role="document">
    				<div class="modal-content">
      					<div class="modal-header">
        					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        					<h4 class="modal-title" id="myModalLabel">Užduok mums klausimą</h4>
      					</div>
      					<div class="modal-body">
        					<?php echo do_shortcode('[contact-form-7 id="61" title="Contact us"]');?>
      					</div>
     
    				</div>
  			</div>
		</div>

</section>
<section id="isitfor" role="region" aria-label="About">
<div class="isitforme">
<span id="isit"></span>
<div class="container narrow">
	<div class="section-header">
		<h2 class="dark-text">Kam skirta ši programa?</h2>
		<div class="colored-line"></div>
</div>
		<center><p>
<?php
$my_id = 29;
$page_id = get_post($my_id);
$content = $page_id->post_content;
echo substr($content, 0, 3050);

?>


</p></center>
		
</div>
</div>
</section>
<section id="kodel">
	<div class="container">
		<div class="section-header">
		<h2 class="dark-text">Kodėl žmonės dalyvauja atradimai.lt programoje?</h2>
		<div class="colored-line"></div>
</div>
		<div class="row">
			<div class="col-md-6">
				<h3>Nežinau, ko noriu</h3>
				<p>Ko nori ne mano tėvai, ne mokykla, ne visuomenė, o būtent aš? Kaip atrasti savo tikruosius norus?</p>
				<h3>Nežinau, kokie mano tikslai</h3>
				<p>Visi aplinkui šaukia: “turėk tikslus”, “siek savo gyvenimo tikslo”, tačiau aš nežinau kokie mano gyvenimo tikslai. Noriu juos atrasti, išmokti išsikelti ir pasiekti.</p>
				<h3>Noras atrasti mėgstamą veiklą</h3>
				<p>Noriu suprasti, kokia veikla man suteikia daugiausiai pasitenkinimo ir džiaugsmo. Kam turiu daug motyvacijos ir entuziazmo veikti, kad nereikėtų laukti “spyrio į užpakalį”.</p>
			</div>
			<div class="col-md-6">
				<h3>Noriu daugiau tobulėti</h3>
				<p>Man svarbu nuolatos augti ir tobulėti. Žinau, kad norėdamas pasiekti aukštų rezultatų, turiu skirti dėmesio asmeniniam augimui.</p>
				<h3>Žinau, kad galiu daugiau</h3>
				<p>Kiekvienas kurioje nors srityje yra gabus, aš - ne išimtis, tačiau nežinau, kokia tai sritis ir kaip galiu panaudoti savo talentus.</p>
				<h3>Noriu sužinoti, ką galiu daryti geriausiai</h3>
				<p>Noriu suprasti, ką veikdamas galiu pasiekti aukščiausių rezultatų, o dar svarbiau – noriu atrasti veiklą, kuri yra prasminga, kurios pasiekimai džiugina  ir kuria užsiimdamas esu laimingas.</p>
			</div>
			
		</div></br></br>
	</div>
</section>
<section id="how2">
<div class="container narrow">
	<h2 style="text-align: center;">Jeigu tau aktualūs šie klausimai, dalyvauk atradimai.lt</br>  7 savaičių savęs pažinimo programoje</h2>
</div></section>
<span id="how"></span>
<div class="container narrow">
	<div class="section-header">
		<h2 class="dark-text">Kaip viskas vyks?</h2>
		<div class="colored-line"></div>
		
</div>
	<p><b>Kiekvieną sekmadienį  20-21 val. el. paštu tu gausi:</b></p>
	<ul>
		<li>Atrinktas, aiškiai ir suprantamai pateiktas užduotis.</li>
		<li>Klausimus savirefleksijai bei atsakymus į dažniausiai užduodamus klausimus.</li>
		<li>Rekomendacijas, ką gali daryti papildomai. </li>
		<li>Metodų, padedančių geriau pažinti save, pasiūlymus.</li></ul>
<p><b>Produktyviai dalyvauti programoje užtenka tik 2-4 val. per savaitę.</b></p>
	<center><img src="http://atradimai.lt/wp-content/uploads/2016/03/schema-atradimai.lt_-1.png" width="800" style="margin-top: -20px;"></center>
	<p>El. paštu tu gausi viską, ko reikia, norint kokybiškai dalyvauti programoje. Programoje pateiksime istorijas, kurios padės geriau suprasti pasirinktas užduočių bei savaitės temas.</p>


<p><b>Programoje tu rasi atsakymus į šiuos klausimus:</b></p>
<a class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseExample1" aria-expanded="false" aria-controls="collapseExample1">Skaityti daugiau</a>
		<div class="collapse" id="collapseExample1">
  			<div class="well work">
				<div class="worklayer">


<p><?php
$my_id = 35;
$page_id = get_post($my_id);
$content = $page_id->post_content;
echo substr($content, 0, 3050);

?>
</p> </div>
  			</div>
		</div>

</div>
<section id="how1" role="region" aria-label="About">
<span id="testimonials"></span>
<div class="container">
	<div class="section-header">
		<h2 class="dark-text">Ką sako dalyviai apie programą?</h2>
		<div class="colored-line"></div>
</div>

		      <div id="owl-example" class="owl-carousel">

<?php query_posts('cat=1');?>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<div class="testi">
		<?php the_post_thumbnail(); ?> 
	<p><?php the_content(); ?><div class="testi-title"><?php the_title(); ?></div></div>
	
	<?php endwhile; else: endif; ?>
    </div>
</div><!-- .testimonials -->
</section>
<section id="faq1" role="region" aria-label="About">
<span id="faq"></span>
<div class="container narrow">
	<div class="section-header">
		<h2 class="dark-text">Perskaityk ir užsiregistruok</h2>
		<div class="colored-line"></div>
</div>

		<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
<?php query_posts('cat=3');?>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<div class="panel panel-default">
		  <div class="panel-heading" role="tab" id="heading">
      			<h4 class="panel-title">
        			<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#<?php the_ID(); ?>" aria-expanded="false" aria-controls="<?php the_ID(); ?>">
          			<?php the_title(); ?>
       				 </a>
      			</h4>
    		</div>
		<div id="<?php the_ID(); ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="label">
      <div class="panel-body">
        <p><?php the_content(); ?>
      </div>
    </div>
  </div>
<?php endwhile; else: endif; ?>
</div>

</div><!-- .faq -->
</section>
<section id="registerr" role="region" aria-label="About">
<span id="register"></span>
<div class="container">
	<div class="section-header">
		<h2 class="dark-text">Užsiregistruoti</h2>
		<h3><?php
$my_id = 188;
$page_id = get_post($my_id);
$content = $page_id->post_content;
echo substr($content, 0, 3050);

?>
</h3>
		<div class="colored-line"></div>
	</div>
	<div class="registration col-md-6">
		<?php echo do_shortcode('[contact-form-7 id="26" title="Registration"]');?>
		</div>
	<div class="registration1 col-md-6">
		
<p>Programa prasideda jau šį sekmadienį </p>
<p>7 savaičių programos kaina tik 37 €. </p>
<p>Investuok į save. Skirk dėmesio asmeniniam augimui.</p>
</div>
		
</div><!-- .register -->
</section>

<div class="supportblock">
	<a class="supportbtn" onclick="toggle_visibility('foo');">Užduoti klausimą</a>
	<div id="foo" class="supportcontent" style="display:none;"><?php echo do_shortcode('[contact-form-7 id="61" title="Contact us"]');?></div>
</div>
<div class="supportblock1">
	<a data-toggle="modal" data-target="#myModal2" class="supportbtn">Prenumeruoti naujienas</a>
</div>

</div>
	</div><!-- .content-wrap -->

	<?php 

	get_footer();
} else {

	include( get_page_template() );
}
?>