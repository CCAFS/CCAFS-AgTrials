== What is this ==

This is a symfony plugin that will add the jQuery based thickbox functionality. See the [http://jquery.com/demo/thickbox/ thickbox site] for more information.

== Requirements ==

This requires jQuery.js available via [wiki:sfUJSPlugin] or you can download it separately.  This README assumes  %SF_JQUERY_WEB_DIR%/js/jquery.js

NOTE: jQuery does NOT come with this plugin, but *IS* required for it to work. You can either download it via the jQuery website or use the sfUJSPlugin as mentioned above. If you've downloaded it, place it in your web/js/ directory and then edit yourapp/config/view.yml to include it:

{{{
default:
...
  javascripts:    [jquery]

}}}

== Install ==

Installation is available via svn only.  From your project root type:

{{{
svn propedit svn:externals plugins
}}}

and add the line:

{{{
mqThickboxPlugin http://svn.symfony-project.com/plugins/mqThickboxPlugin
}}}

Then run:

{{{
svn up
}}}

If you are using a symlink aware system you can run:

{{{
symfony mqThickboxPlugin-install
}}}

To create the appropriate symlinks.

== Usage ==

First, see the official [http://jquery.com/demo/thickbox/ documentation].

Here are some examples of usage that match the examples on the documentation page:

'''Single Image:'''
{{{
<?php echo thickbox_image('single_thumb.jpg', 'single.jpg', array('title' => 'Single Image')) ?>
}}}

Additional options can be set for the thumbnail image like so:
{{{
<?php echo thickbox_image('single_thumb.jpg', 'single.jpg', array('title' => 'Single Image'), array('size' => '120x120')) ?>
}}}


'''Gallery Images:'''
{{{
<?php echo thickbox_image('single1_thumb.jpg', 'single1.jpg', array('rel' => 'gallery1', 'title' => 'Single Image 1')) ?>
<?php echo thickbox_image('single2_thumb.jpg', 'single2.jpg', array('rel' => 'gallery1', 'title' => 'Single Image 2')) ?>
<?php echo thickbox_image('single3_thumb.jpg', 'single3.jpg', array('rel' => 'gallery1', 'title' => 'Single Image 3')) ?>

<?php echo thickbox_image('single4_thumb.jpg', 'single4.jpg', array('rel' => 'gallery2', 'title' => 'Single Image 4')) ?>
<?php echo thickbox_image('single5_thumb.jpg', 'single5.jpg', array('rel' => 'gallery2', 'title' => 'Single Image 5')) ?>
<?php echo thickbox_image('single6_thumb.jpg', 'single6.jpg', array('rel' => 'gallery2', 'title' => 'Single Image 6')) ?>
}}}

You'll notice this is example is exactly the same as the single image example, except that we're adding a "rel" attribute to the image that will group these images into two sets, "gallery1" and "gallery2." 


'''Inline Content'''
{{{
<?php echo thickbox_inline('Show', 'something_hidden') ?>

<div id="something_hidden" style="display:none;">
	<p>test</p>
</div>
}}}

You can also add html and thickbox options like so:
{{{
<?php echo thickbox_inline('Show', 'something_hidden', array('style' => 'font-weight:bold'), array('size' => '300x400', 'modal' => 'true')) ?>
}}}


'''IFramed Content'''
{{{
<?php echo thickbox_iframe('Google in a thickbox', 'http://google.com') ?>
}}}


'''AJAX Content'''
{{{
<?php echo thickbox_ajax('Signin via thickbox', '@sf_guard_signin') ?>
}}}

Additional html and thickbox options can also be set in the same manner as with the inline content for both iframe and ajax content.

Also, as can be seen in the ajax content example, any symfony routing rule can be used for a url.

You can now override the thickbox styles in your own css file by adding the appropriate css definitions to your stylesheet. For example, to change the overlay's background color, opacity and border, just redefine it in your main.css like so:

{{{
.TB_overlayBG
{
	background-color: #fff;
	filter:alpha(opacity=65);
	-moz-opacity: 0.65;
	opacity: 0.65;
}

#TB_window {
	border: 1px solid #ccc;
}

}}}

You may also need to edit and include a version of the macFFBgHack.png file (located in mqThickboxPlugin/web/images/) that matches the above background color and redefine it in your stylesheet:

{{{
.TB_overlayMacFFBGHack {background: url('/images/macFFBgHack_white.png') repeat;}
}}}

See the thickbox.css file for other styles that can be overridden.

== Developers ==

This plugin is developed by Mark Quezada.  To contribute email mark <at> mirthlab.com or submit patches assigned to 'Mark.Quezada' in trac.

== Changelog ==

2007/10/19: Added additional helpers for iframe, inline and ajax content. Updated the documentation with examples.

2007/10/18: Initial commit