<?php
/**
 * GInput class file.
 *
 * @author Gustavo Salgado <gsalgadotoledo@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright 2008-2013 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * GInput displays a star rating control that can collect user rating input.
 *
 * GInput is based on {@link http://www.fyneworks.com/jquery/star-rating/ jQuery Star Rating Plugin}.
 * It displays a list of stars indicating the rating values. Users can toggle these stars
 * to indicate their rating input. On the server side, when the rating input is submitted,
 * the value can be retrieved in the same way as working with a normal HTML input.
 * For example, using
 * <pre>
 * $this->widget('pat.to.location.GInput',array('name'=>'rating'));
 * </pre>
 * we can retrieve the rating value via <code>$_POST['rating']</code>.
 *
 * GInput allows customization of its appearance. It also supports empty rating as well as read-only rating.
 *
 * @author Gustavo Salgado <gsalgadotoledo@gmail.com>
 * @package system.web.widgets
 * @since 1.0
 */
class GFontAwesome extends CInputWidget
{
	// @TODO AT ALL
	public $listData=array(
			'fa-adjust'=>'<i class="fa fa-adjust"></i>',
			'fa-anchor'=>'<i class="fa fa-anchor"></i>',
			'fa-archive'=>'<i class="fa fa-archive"></i>',
			'fa-area-chart'=>'<i class="fa fa-area-chart"></i>',
			'fa-arrows'=>'<i class="fa fa-arrows"></i>',
			'fa-arrows-h'=>'<i class="fa fa-arrows-h"></i>',
			'fa-arrows-v'=>'<i class="fa fa-arrows-v"></i>',
			'fa-asterisk'=>'<i class="fa fa-asterisk"></i>',
			'fa-automobile'=>'<i class="fa fa-automobile"></i>',
			'fa-ban'=>'<i class="fa fa-ban"></i>',
			'fa-bank'=>'<i class="fa fa-bank"></i>',
			'fa-bar-chart'=>'<i class="fa fa-bar-chart"></i>',
			'fa-bar-chart-o'=>'<i class="fa fa-bar-chart-o"></i>',
			'fa-barcode'=>'<i class="fa fa-barcode"></i>',
			'fa-bars'=>'<i class="fa fa-bars"></i>',
			'fa-beer'=>'<i class="fa fa-beer"></i>',
			'fa-bell'=>'<i class="fa fa-bell"></i>',
			'fa-bell-o'=>'<i class="fa fa-bell-o"></i>',
			'fa-bell-slash'=>'<i class="fa fa-bell-slash"></i>',
			'fa-bell-slash-o'=>'<i class="fa fa-bell-slash-o"></i>',
			'fa-bicycle'=>'<i class="fa fa-bicycle"></i>',
			'fa-binoculars'=>'<i class="fa fa-binoculars"></i>',
			'fa-birthday-cake'=>'<i class="fa fa-birthday-cake"></i>',
			'fa-bolt'=>'<i class="fa fa-bolt"></i>',
			'fa-bomb'=>'<i class="fa fa-bomb"></i>',
			'fa-book'=>'<i class="fa fa-book"></i>',
			'fa-bookmark'=>'<i class="fa fa-bookmark"></i>',
			'fa-bookmark-o'=>'<i class="fa fa-bookmark-o"></i>',
			'fa-briefcase'=>'<i class="fa fa-briefcase"></i>',
			'fa-bug'=>'<i class="fa fa-bug"></i>',
			'fa-building'=>'<i class="fa fa-building"></i>',
			'fa-building-o'=>'<i class="fa fa-building-o"></i>',
			'fa-bullhorn'=>'<i class="fa fa-bullhorn"></i>',
			'fa-bullseye'=>'<i class="fa fa-bullseye"></i>',
			'fa-bus'=>'<i class="fa fa-bus"></i>',
			'fa-cab'=>'<i class="fa fa-cab"></i>',
			'fa-calculator'=>'<i class="fa fa-calculator"></i>',
			'fa-calendar'=>'<i class="fa fa-calendar"></i>',
			'fa-calendar-o'=>'<i class="fa fa-calendar-o"></i>',
			'fa-camera'=>'<i class="fa fa-camera"></i>',
			'fa-camera-retro'=>'<i class="fa fa-camera-retro"></i>',
			'fa-car'=>'<i class="fa fa-car"></i>',
			'fa-caret-square-o-down'=>'<i class="fa fa-caret-square-o-down"></i>',
			'fa-caret-square-o-left'=>'<i class="fa fa-caret-square-o-left"></i>',
			'fa-caret-square-o-right'=>'<i class="fa fa-caret-square-o-right"></i>',
			'fa-caret-square-o-up'=>'<i class="fa fa-caret-square-o-up"></i>',
			'fa-cc'=>'<i class="fa fa-cc"></i>',
			'fa-certificate'=>'<i class="fa fa-certificate"></i>',
			'fa-check'=>'<i class="fa fa-check"></i>',
			'fa-check-circle'=>'<i class="fa fa-check-circle"></i>',
			'fa-check-circle-o'=>'<i class="fa fa-check-circle-o"></i>',
			'fa-check-square'=>'<i class="fa fa-check-square"></i>',
			'fa-check-square-o'=>'<i class="fa fa-check-square-o"></i>',
			'fa-child'=>'<i class="fa fa-child"></i>',
			'fa-circle'=>'<i class="fa fa-circle"></i>',
			'fa-circle-o'=>'<i class="fa fa-circle-o"></i>',
			'fa-circle-o-notch'=>'<i class="fa fa-circle-o-notch"></i>',
			'fa-circle-thin'=>'<i class="fa fa-circle-thin"></i>',
			'fa-clock-o'=>'<i class="fa fa-clock-o"></i>',
			'fa-close'=>'<i class="fa fa-close"></i>',
			'fa-cloud'=>'<i class="fa fa-cloud"></i>',
			'fa-cloud-download'=>'<i class="fa fa-cloud-download"></i>',
			'fa-cloud-upload'=>'<i class="fa fa-cloud-upload"></i>',
			'fa-code'=>'<i class="fa fa-code"></i>',
			'fa-code-fork'=>'<i class="fa fa-code-fork"></i>',
			'fa-coffee'=>'<i class="fa fa-coffee"></i>',
			'fa-cog'=>'<i class="fa fa-cog"></i>',
			'fa-cogs'=>'<i class="fa fa-cogs"></i>',
			'fa-comment'=>'<i class="fa fa-comment"></i>',
			'fa-comment-o'=>'<i class="fa fa-comment-o"></i>',
			'fa-comments'=>'<i class="fa fa-comments"></i>',
			'fa-comments-o'=>'<i class="fa fa-comments-o"></i>',
			'fa-compass'=>'<i class="fa fa-compass"></i>',
			'fa-copyright'=>'<i class="fa fa-copyright"></i>',
			'fa-credit-card'=>'<i class="fa fa-credit-card"></i>',
			'fa-crop'=>'<i class="fa fa-crop"></i>',
			'fa-crosshairs'=>'<i class="fa fa-crosshairs"></i>',
			'fa-cube'=>'<i class="fa fa-cube"></i>',
			'fa-cubes'=>'<i class="fa fa-cubes"></i>',
			'fa-cutlery'=>'<i class="fa fa-cutlery"></i>',
			'fa-dashboard'=>'<i class="fa fa-dashboard"></i>',
			'fa-database'=>'<i class="fa fa-database"></i>',
			'fa-desktop'=>'<i class="fa fa-desktop"></i>',
			'fa-dot-circle-o'=>'<i class="fa fa-dot-circle-o"></i>',
			'fa-download'=>'<i class="fa fa-download"></i>',
			'fa-edit'=>'<i class="fa fa-edit"></i>',
			'fa-ellipsis-h'=>'<i class="fa fa-ellipsis-h"></i>',
			'fa-ellipsis-v'=>'<i class="fa fa-ellipsis-v"></i>',
			'fa-envelope'=>'<i class="fa fa-envelope"></i>',
			'fa-envelope-o'=>'<i class="fa fa-envelope-o"></i>',
			'fa-envelope-square'=>'<i class="fa fa-envelope-square"></i>',
			'fa-eraser'=>'<i class="fa fa-eraser"></i>',
			'fa-exchange'=>'<i class="fa fa-exchange"></i>',
			'fa-exclamation'=>'<i class="fa fa-exclamation"></i>',
			'fa-exclamation-circle'=>'<i class="fa fa-exclamation-circle"></i>',
			'fa-exclamation-triangle'=>'<i class="fa fa-exclamation-triangle"></i>',
			'fa-external-link'=>'<i class="fa fa-external-link"></i>',
			'fa-external-link-square'=>'<i class="fa fa-external-link-square"></i>',
			'fa-eye'=>'<i class="fa fa-eye"></i>',
			'fa-eye-slash'=>'<i class="fa fa-eye-slash"></i>',
			'fa-eyedropper'=>'<i class="fa fa-eyedropper"></i>',
			'fa-fax'=>'<i class="fa fa-fax"></i>',
			'fa-female'=>'<i class="fa fa-female"></i>',
			'fa-fighter-jet'=>'<i class="fa fa-fighter-jet"></i>',
			'fa-file-archive-o'=>'<i class="fa fa-file-archive-o"></i>',
			'fa-file-audio-o'=>'<i class="fa fa-file-audio-o"></i>',
			'fa-file-code-o'=>'<i class="fa fa-file-code-o"></i>',
			'fa-file-excel-o'=>'<i class="fa fa-file-excel-o"></i>',
			'fa-file-image-o'=>'<i class="fa fa-file-image-o"></i>',
			'fa-file-movie-o'=>'<i class="fa fa-file-movie-o"></i>',
			'fa-file-pdf-o'=>'<i class="fa fa-file-pdf-o"></i>',
			'fa-file-photo-o'=>'<i class="fa fa-file-photo-o"></i>',
			'fa-file-picture-o'=>'<i class="fa fa-file-picture-o"></i>',
			'fa-file-powerpoint-o'=>'<i class="fa fa-file-powerpoint-o"></i>',
			'fa-file-sound-o'=>'<i class="fa fa-file-sound-o"></i>',
			'fa-file-video-o'=>'<i class="fa fa-file-video-o"></i>',
			'fa-file-word-o'=>'<i class="fa fa-file-word-o"></i>',
			'fa-file-zip-o'=>'<i class="fa fa-file-zip-o"></i>',
			'fa-film'=>'<i class="fa fa-film"></i>',
			'fa-filter'=>'<i class="fa fa-filter"></i>',
			'fa-fire'=>'<i class="fa fa-fire"></i>',
			'fa-fire-extinguisher'=>'<i class="fa fa-fire-extinguisher"></i>',
			'fa-flag'=>'<i class="fa fa-flag"></i>',
			'fa-flag-checkered'=>'<i class="fa fa-flag-checkered"></i>',
			'fa-flag-o'=>'<i class="fa fa-flag-o"></i>',
			'fa-flash'=>'<i class="fa fa-flash"></i>',
			'fa-flask'=>'<i class="fa fa-flask"></i>',
			'fa-folder'=>'<i class="fa fa-folder"></i>',
			'fa-folder-o'=>'<i class="fa fa-folder-o"></i>',
			'fa-folder-open'=>'<i class="fa fa-folder-open"></i>',
			'fa-folder-open-o'=>'<i class="fa fa-folder-open-o"></i>',
			'fa-frown-o'=>'<i class="fa fa-frown-o"></i>',
			'fa-futbol-o'=>'<i class="fa fa-futbol-o"></i>',
			'fa-gamepad'=>'<i class="fa fa-gamepad"></i>',
			'fa-gavel'=>'<i class="fa fa-gavel"></i>',
			'fa-gear'=>'<i class="fa fa-gear"></i>',
			'fa-gears'=>'<i class="fa fa-gears"></i>',
			'fa-gift'=>'<i class="fa fa-gift"></i>',
			'fa-glass'=>'<i class="fa fa-glass"></i>',
			'fa-globe'=>'<i class="fa fa-globe"></i>',
			'fa-graduation-cap'=>'<i class="fa fa-graduation-cap"></i>',
			'fa-group'=>'<i class="fa fa-group"></i>',
			'fa-hdd-o'=>'<i class="fa fa-hdd-o"></i>',
			'fa-headphones'=>'<i class="fa fa-headphones"></i>',
			'fa-heart'=>'<i class="fa fa-heart"></i>',
			'fa-heart-o'=>'<i class="fa fa-heart-o"></i>',
			'fa-history'=>'<i class="fa fa-history"></i>',
			'fa-home'=>'<i class="fa fa-home"></i>',
			'fa-image'=>'<i class="fa fa-image"></i>',
			'fa-inbox'=>'<i class="fa fa-inbox"></i>',
			'fa-info'=>'<i class="fa fa-info"></i>',
			'fa-info-circle'=>'<i class="fa fa-info-circle"></i>',
			'fa-institution'=>'<i class="fa fa-institution"></i>',
			'fa-key'=>'<i class="fa fa-key"></i>',
			'fa-keyboard-o'=>'<i class="fa fa-keyboard-o"></i>',
			'fa-language'=>'<i class="fa fa-language"></i>',
			'fa-laptop'=>'<i class="fa fa-laptop"></i>',
			'fa-leaf'=>'<i class="fa fa-leaf"></i>',
			'fa-legal'=>'<i class="fa fa-legal"></i>',
			'fa-lemon-o'=>'<i class="fa fa-lemon-o"></i>',
			'fa-level-down'=>'<i class="fa fa-level-down"></i>',
			'fa-level-up'=>'<i class="fa fa-level-up"></i>',
			'fa-life-bouy'=>'<i class="fa fa-life-bouy"></i>',
			'fa-life-buoy'=>'<i class="fa fa-life-buoy"></i>',
			'fa-life-ring'=>'<i class="fa fa-life-ring"></i>',
			'fa-life-saver'=>'<i class="fa fa-life-saver"></i>',
			'fa-lightbulb-o'=>'<i class="fa fa-lightbulb-o"></i>',
			'fa-line-chart'=>'<i class="fa fa-line-chart"></i>',
			'fa-location-arrow'=>'<i class="fa fa-location-arrow"></i>',
			'fa-lock'=>'<i class="fa fa-lock"></i>',
			'fa-magic'=>'<i class="fa fa-magic"></i>',
			'fa-magnet'=>'<i class="fa fa-magnet"></i>',
			'fa-mail-forward'=>'<i class="fa fa-mail-forward"></i>',
			'fa-mail-reply'=>'<i class="fa fa-mail-reply"></i>',
			'fa-mail-reply-all'=>'<i class="fa fa-mail-reply-all"></i>',
			'fa-male'=>'<i class="fa fa-male"></i>',
			'fa-map-marker'=>'<i class="fa fa-map-marker"></i>',
			'fa-meh-o'=>'<i class="fa fa-meh-o"></i>',
			'fa-microphone'=>'<i class="fa fa-microphone"></i>',
			'fa-microphone-slash'=>'<i class="fa fa-microphone-slash"></i>',
			'fa-minus'=>'<i class="fa fa-minus"></i>',
			'fa-minus-circle'=>'<i class="fa fa-minus-circle"></i>',
			'fa-minus-square'=>'<i class="fa fa-minus-square"></i>',
			'fa-minus-square-o'=>'<i class="fa fa-minus-square-o"></i>',
			'fa-mobile'=>'<i class="fa fa-mobile"></i>',
			'fa-mobile-phone'=>'<i class="fa fa-mobile-phone"></i>',
			'fa-money'=>'<i class="fa fa-money"></i>',
			'fa-moon-o'=>'<i class="fa fa-moon-o"></i>',
			'fa-mortar-board'=>'<i class="fa fa-mortar-board"></i>',
			'fa-music'=>'<i class="fa fa-music"></i>',
			'fa-navicon'=>'<i class="fa fa-navicon"></i>',
			'fa-newspaper-o'=>'<i class="fa fa-newspaper-o"></i>',
			'fa-paint-brush'=>'<i class="fa fa-paint-brush"></i>',
			'fa-paper-plane'=>'<i class="fa fa-paper-plane"></i>',
			'fa-paper-plane-o'=>'<i class="fa fa-paper-plane-o"></i>',
			'fa-paw'=>'<i class="fa fa-paw"></i>',
			'fa-pencil'=>'<i class="fa fa-pencil"></i>',
			'fa-pencil-square'=>'<i class="fa fa-pencil-square"></i>',
			'fa-pencil-square-o'=>'<i class="fa fa-pencil-square-o"></i>',
			'fa-phone'=>'<i class="fa fa-phone"></i>',
			'fa-phone-square'=>'<i class="fa fa-phone-square"></i>',
			'fa-photo'=>'<i class="fa fa-photo"></i>',
			'fa-picture-o'=>'<i class="fa fa-picture-o"></i>',
			'fa-pie-chart'=>'<i class="fa fa-pie-chart"></i>',
			'fa-plane'=>'<i class="fa fa-plane"></i>',
			'fa-plug'=>'<i class="fa fa-plug"></i>',
			'fa-plus'=>'<i class="fa fa-plus"></i>',
			'fa-plus-circle'=>'<i class="fa fa-plus-circle"></i>',
			'fa-plus-square'=>'<i class="fa fa-plus-square"></i>',
			'fa-plus-square-o'=>'<i class="fa fa-plus-square-o"></i>',
			'fa-power-off'=>'<i class="fa fa-power-off"></i>',
			'fa-print'=>'<i class="fa fa-print"></i>',
			'fa-puzzle-piece'=>'<i class="fa fa-puzzle-piece"></i>',
			'fa-qrcode'=>'<i class="fa fa-qrcode"></i>',
			'fa-question'=>'<i class="fa fa-question"></i>',
			'fa-question-circle'=>'<i class="fa fa-question-circle"></i>',
			'fa-quote-left'=>'<i class="fa fa-quote-left"></i>',
			'fa-quote-right'=>'<i class="fa fa-quote-right"></i>',
			'fa-random'=>'<i class="fa fa-random"></i>',
			'fa-recycle'=>'<i class="fa fa-recycle"></i>',
			'fa-refresh'=>'<i class="fa fa-refresh"></i>',
			'fa-remove'=>'<i class="fa fa-remove"></i>',
			'fa-reorder'=>'<i class="fa fa-reorder"></i>',
			'fa-reply'=>'<i class="fa fa-reply"></i>',
			'fa-reply-all'=>'<i class="fa fa-reply-all"></i>',
			'fa-retweet'=>'<i class="fa fa-retweet"></i>',
			'fa-road'=>'<i class="fa fa-road"></i>',
			'fa-rocket'=>'<i class="fa fa-rocket"></i>',
			'fa-rss'=>'<i class="fa fa-rss"></i>',
			'fa-rss-square'=>'<i class="fa fa-rss-square"></i>',
			'fa-search'=>'<i class="fa fa-search"></i>',
			'fa-search-minus'=>'<i class="fa fa-search-minus"></i>',
			'fa-search-plus'=>'<i class="fa fa-search-plus"></i>',
			'fa-send'=>'<i class="fa fa-send"></i>',
			'fa-send-o'=>'<i class="fa fa-send-o"></i>',
			'fa-share'=>'<i class="fa fa-share"></i>',
			'fa-share-alt'=>'<i class="fa fa-share-alt"></i>',
			'fa-share-alt-square'=>'<i class="fa fa-share-alt-square"></i>',
			'fa-share-square'=>'<i class="fa fa-share-square"></i>',
			'fa-share-square-o'=>'<i class="fa fa-share-square-o"></i>',
			'fa-shield'=>'<i class="fa fa-shield"></i>',
			'fa-shopping-cart'=>'<i class="fa fa-shopping-cart"></i>',
			'fa-sign-in'=>'<i class="fa fa-sign-in"></i>',
			'fa-sign-out'=>'<i class="fa fa-sign-out"></i>',
			'fa-signal'=>'<i class="fa fa-signal"></i>',
			'fa-sitemap'=>'<i class="fa fa-sitemap"></i>',
			'fa-sliders'=>'<i class="fa fa-sliders"></i>',
			'fa-smile-o'=>'<i class="fa fa-smile-o"></i>',
			'fa-soccer-ball-o'=>'<i class="fa fa-soccer-ball-o"></i>',
			'fa-sort'=>'<i class="fa fa-sort"></i>',
			'fa-sort-alpha-asc'=>'<i class="fa fa-sort-alpha-asc"></i>',
			'fa-sort-alpha-desc'=>'<i class="fa fa-sort-alpha-desc"></i>',
			'fa-sort-amount-asc'=>'<i class="fa fa-sort-amount-asc"></i>',
			'fa-sort-amount-desc'=>'<i class="fa fa-sort-amount-desc"></i>',
			'fa-sort-asc'=>'<i class="fa fa-sort-asc"></i>',
			'fa-sort-desc'=>'<i class="fa fa-sort-desc"></i>',
			'fa-sort-down'=>'<i class="fa fa-sort-down"></i>',
			'fa-sort-numeric-asc'=>'<i class="fa fa-sort-numeric-asc"></i>',
			'fa-sort-numeric-desc'=>'<i class="fa fa-sort-numeric-desc"></i>',
			'fa-sort-up'=>'<i class="fa fa-sort-up"></i>',
			'fa-space-shuttle'=>'<i class="fa fa-space-shuttle"></i>',
			'fa-spinner'=>'<i class="fa fa-spinner"></i>',
			'fa-spoon'=>'<i class="fa fa-spoon"></i>',
			'fa-square'=>'<i class="fa fa-square"></i>',
			'fa-square-o'=>'<i class="fa fa-square-o"></i>',
			'fa-star'=>'<i class="fa fa-star"></i>',
			'fa-star-half'=>'<i class="fa fa-star-half"></i>',
			'fa-star-half-empty'=>'<i class="fa fa-star-half-empty"></i>',
			'fa-star-half-full'=>'<i class="fa fa-star-half-full"></i>',
			'fa-star-half-o'=>'<i class="fa fa-star-half-o"></i>',
			'fa-star-o'=>'<i class="fa fa-star-o"></i>',
			'fa-suitcase'=>'<i class="fa fa-suitcase"></i>',
			'fa-sun-o'=>'<i class="fa fa-sun-o"></i>',
			'fa-support'=>'<i class="fa fa-support"></i>',
			'fa-tablet'=>'<i class="fa fa-tablet"></i>',
			'fa-tachometer'=>'<i class="fa fa-tachometer"></i>',
			'fa-tag'=>'<i class="fa fa-tag"></i>',
			'fa-tags'=>'<i class="fa fa-tags"></i>',
			'fa-tasks'=>'<i class="fa fa-tasks"></i>',
			'fa-taxi'=>'<i class="fa fa-taxi"></i>',
			'fa-terminal'=>'<i class="fa fa-terminal"></i>',
			'fa-thumb-tack'=>'<i class="fa fa-thumb-tack"></i>',
			'fa-thumbs-down'=>'<i class="fa fa-thumbs-down"></i>',
			'fa-thumbs-o-down'=>'<i class="fa fa-thumbs-o-down"></i>',
			'fa-thumbs-o-up'=>'<i class="fa fa-thumbs-o-up"></i>',
			'fa-thumbs-up'=>'<i class="fa fa-thumbs-up"></i>',
			'fa-ticket'=>'<i class="fa fa-ticket"></i>',
			'fa-times'=>'<i class="fa fa-times"></i>',
			'fa-times-circle'=>'<i class="fa fa-times-circle"></i>',
			'fa-times-circle-o'=>'<i class="fa fa-times-circle-o"></i>',
			'fa-tint'=>'<i class="fa fa-tint"></i>',
			'fa-toggle-down'=>'<i class="fa fa-toggle-down"></i>',
			'fa-toggle-left'=>'<i class="fa fa-toggle-left"></i>',
			'fa-toggle-off'=>'<i class="fa fa-toggle-off"></i>',
			'fa-toggle-on'=>'<i class="fa fa-toggle-on"></i>',
			'fa-toggle-right'=>'<i class="fa fa-toggle-right"></i>',
			'fa-toggle-up'=>'<i class="fa fa-toggle-up"></i>',
			'fa-trash'=>'<i class="fa fa-trash"></i>',
			'fa-trash-o'=>'<i class="fa fa-trash-o"></i>',
			'fa-tree'=>'<i class="fa fa-tree"></i>',
			'fa-trophy'=>'<i class="fa fa-trophy"></i>',
			'fa-truck'=>'<i class="fa fa-truck"></i>',
			'fa-tty'=>'<i class="fa fa-tty"></i>',
			'fa-umbrella'=>'<i class="fa fa-umbrella"></i>',
			'fa-university'=>'<i class="fa fa-university"></i>',
			'fa-unlock'=>'<i class="fa fa-unlock"></i>',
			'fa-unlock-alt'=>'<i class="fa fa-unlock-alt"></i>',
			'fa-unsorted'=>'<i class="fa fa-unsorted"></i>',
			'fa-upload'=>'<i class="fa fa-upload"></i>',
			'fa-user'=>'<i class="fa fa-user"></i>',
			'fa-users'=>'<i class="fa fa-users"></i>',
			'fa-video-camera'=>'<i class="fa fa-video-camera"></i>',
			'fa-volume-down'=>'<i class="fa fa-volume-down"></i>',
			'fa-volume-off'=>'<i class="fa fa-volume-off"></i>',
			'fa-volume-up'=>'<i class="fa fa-volume-up"></i>',
			'fa-warning'=>'<i class="fa fa-warning"></i>',
			'fa-wheelchair'=>'<i class="fa fa-wheelchair"></i>',
			'fa-wifi'=>'<i class="fa fa-wifi"></i>',
			'fa-wrench'=>'<i class="fa fa-wrench"></i>',
	);

	private $_assets;
	
	/**
	 * Executes the widget.
	 * This method registers all needed client scripts and renders
	 * the text field.
	 */
	public function run()
	{
		list($name,$id)=$this->resolveNameID();
		if(isset($this->htmlOptions['id']))
			$id=$this->htmlOptions['id'];
		else
			$this->htmlOptions['id']=$id;
		if(isset($this->htmlOptions['name']))
			$name=$this->htmlOptions['name'];

		#$this->registerClientScript($id);
		#$this->htmlOptions["class"]="form-control";
		$this->htmlOptions=array_merge($this->htmlOptions,array(
			// 'htmlOptions'=>array('container'=>null),
			'labelOptions'=>array('style'=>'width: 100%;height: 100%;cursor:pointer','class'=>'ptm pbm mbn'),
			'template'=>'<div class="col-lg-1"><a href="#" class="thumbnail text-center" style="margin-left: -10px;margin-right: -10px;">{beginLabel}{labelTitle}<div class="text-center">{input}</div>{endLabel}</a></div>',
			'separator'=>'',
		));
		
		#echo "<small class=\"text-muted\"><em>Here a message for user</em></small>";
		#echo CHtml::activeTextField($this->model,$this->attribute,$this->htmlOptions);
		echo '<div class="row">'.Chtml::activeRadioButtonList($this->model,$this->attribute,
		  $this->listData,$this->htmlOptions).'</div>';
	}

	/**
	 * Registers the necessary javascript and css scripts.
	 * @param string $id the ID of the container
	 */
	public function registerClientScript($id)
	{
		$js="
			$(function() {
		    	console.log('Hello world');
			});
		";
		$assets=$this->getAssets();
		$cs=Yii::app()->getClientScript();
		// $cs->registerScriptFile("https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=drawing",CClientScript::POS_HEAD);
		// $cs->registerScriptFile($assets."/googleMap.js",CClientScript::POS_HEAD);
		$cs->registerScript('ext.GInput#'.$id,$js,CClientScript::POS_END);
	}

	public function getAssets()
	{
		if($this->_assets===null)
			$this->_assets=Yii::app()->assetManager->publish(dirname(__FILE__)."/assets/");
		return $this->_assets;
	}
}
