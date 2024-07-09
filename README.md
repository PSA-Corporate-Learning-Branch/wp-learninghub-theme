# wp-learninghub
A Wordpress theme for the PSA LearningHUB course catalogue.

This theme depends on an accompanying plugin: 

https://github.com/bcgov/wp-learning-hub

The plugin creates the course post type and associated taxonomies as well
as a synchronization process to match content with:

 - PSA Learning System
 - PSA Learning Curator

Among other benefits, the plugin also enables an expiry date (via custom field)
that will make courses past a certain date removed from the catalogue.

This theme formats the content for courses and provides custom views and filtering 
options for the various taxonomies.

While the technological progress Wordpress has undergone over the past few 
years has been good for some, most of the changes with the block editor and 
full site editing do not meet our needs and really only serve to increase
the amount of specialized knowledge and training needed to create content.

As such, this theme eschews many new Wordpress features. Page content is 
stored in template files and is written in:

 - HTML.
 - Bootstrap 5.3+ for styling.
 - PHP for the dynamic bits.

The theme still works for block-edited content for pages and the blog, but 
we prefer to manage most content "manually."

This is a brand new theme and we'll be filling out documentation for supported
features in the future.