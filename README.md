# SimpleKB
Version: 0.2.1 (10/16/2018)

An intentionally simple WordPress Knowledge Base plugin.

## How to Use
When you install and activate SimpleKB it will add menu items in WP Admin that allow you to create/edit/delete KB articles that will display on the front-end at the URL:

https://mydomain.com/kb/name-of-article/

Subject pages are display on the front-end at the URL:

https://mydomain.com/kb/name-of-subject/

(The latter doesn't currently work)

You can output a list of all the KB articles by using the shortcode:

[simplekb]

## Underlying Implementation

This plugin uses a custom post type (CPT), several taxonomies, and custom permalinks to store and display knowledge base entries.

## Recommended Plugin for User Roles

If you need to provide individuals with access to the knowledge base plugin but don't want them making edits in other areas of your site, I'd recommend Justin Tadlock's Members plugin.

## ToDo
* Auto-create kb user types during activation.
* Fix issue with permalinks for subjects not working.
* Add a settings page.

## Authors

This plugin was created by Dave Mackey. It is based on a simple plugin created by Dave and Rick Murtagh for Liquid Church.

## Release Notes
Please see the document RELEASENOTES.MD for the latest details about what has changed with this version of SimpleKB.
