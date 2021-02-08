First of all, I am not much of a JS expert. But since JS syntax ressembles PHP's, I have managed
to whip up a very simple Google Maps plugin.

Second: this is a VERY VERY crude, elementary first draft. It works and was tested in IE7 and FF2.

Requirements
------------
What you need for Google maps to run on your website, is your very own API key. You can get one here:
http://code.google.com/apis/maps/signup.html 

Installing the plugin
---------------------
Download the plugin from here: http://www.connectcase.nl/bl.google.maps.plugin.tinymce.html
Make a plugins-folder called 'googlemaps'
Unzip all the files into that folder.

Find your tinyMce init statement and add "googlemaps" to the "plugins" line and
add "googlemaps, googlemapsdel" to one of your button lines (like "theme_advanced_buttons3").

This should create 2 buttons: one for adding the Google Map and one for deleting it.

Basics
------
The dialog for this plugin requires 5 variables:

1. API key (get one at http://code.google.com/apis/maps/signup.html)
2. coordinates for your own location (you can get them at http://www.connectcase.nl/bl.google.maps.plugin.tinymce.html)
3. width: how wide do you want the Google div to be? (if left blank --> 100px)
4. height: how high do you want the Google div to be? (if left blank --> 100px)
5. div ID: to refrain from applying a div ID that you already used in your page, you can enter your own here
(if left blank, the div is called "map")

The dialog then creates the necessary Javascript (2 <script> tags) and the div in which the maps is actually shown. 
This is all put in a span called "spangooglemaps".
Forth comes the "googlemapsdel"-button. If clicked, it removes this particular span from the DOM.

Removing the span "spangooglemaps" from the DOM is not the most brilliant solution, I know, but I couldn't figure out how to simply
select the span and then press the delete-button on your keyboard (suggestions are welcome!!)

All the Google Maps examples at Google.com have the Javascript run at the "body onLoad"-statement. Since I assume that most of you use
tinyMce in a CMS environment, in which you cannot access the body-tag, I added some extra Javascript that avoids the necessary js-methods 
to run via the body-tag. (Can't take credit for this nifty piece of code, I just nicked it somewhere on the Internet)

Some day, if this plugin ever loses some of its crudeness, but either development from my side or input from others, I will post it in the Sourceforge repository.
I know that's where it is supposed to go, but this first version is not a "professional" plugin yet, so let's wait a bit longer....

For now, you can download it here: http://www.connectcase.nl/bl.google.maps.plugin.tinymce.html
