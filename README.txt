=== WP Quizr ===
Contributors: amir_canteetu
Tags: quiz, quizzes, buzzfeed quiz, viral, viral quiz
Requires at least: 3.0.1
Tested up to: 4.9.7
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=J78732V5VULA6
Stable tag: 2.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Create Buzzfeed-style quizzes and share results on social media.

== Description ==

Allows you to create multiple-choice question quizzes, like those on the Buzzfeed website. 

Allows you to create as many questions as you wish, each with as many picture outcomes as you wish. Each of the picture 
outcomes may or may not be associated with a particular result. Place the quiz in a post or page by pasting in its shortcode.

Users click on picture answer choices, each of which may (or may not) be associated with a final outcome. After the final picture is clicked on, a result is revealed and users can share this on social media networks of their choice.

NB: PLEASE READ README.TXT FILE IN THE THE WP-QUIZR FOLDER FOR DETAILED USAGE INSTRUCTIONS; AND DON'T FORGET TO PROVIDE FEEDBACK. THANKS!  

== Installation ==

1. Upload the wp-quizr folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress


== Frequently Asked Questions ==

= How many questions can be set? =

As many as you wish.

= What should I do after installing? =

See the "User Guide" below with usage instructions

= Does the plugin use shortcodes? =

Yes

= Can I place the quiz in a post or page? =

Yes the quiz can be included in a post or page by pasting in its shortcode on the post/page edit page.

== Screenshots ==

1. Easily add quiz questions and outcomes. Plugin also allows the use of shortcodes.

2. Specify Social Network IDs 

3. Users select their answers by a click.

4. Users select their answers by a click.

5. Users can share their results on social media networks.

== Changelog ==

= 2.0.0 =

*more responsive updates on both front-end and cms

*automatic scroll to next quiz question after click

= 1.2.0 =

* css changes to make quiz table responsive

*security enhancements

* php 7+ ready

* refactored code

* cms ux enhancements


= 1.0.5 =

*Added number of columns option in shortcode

*Added option to shuffle answer choices.

* Added option to change table width

* CSS changes to sharing buttons

* Minified css

= 1.0.2 =

Added a rating notice.

= 1.0.1 =
*Release Date - 5 September 2015*

* Changed css styling to make quiz layout wider: 625px.

* Added option for captions on image answer choices

* Social IDs no longer required to create quizzes

= 1.0.0 =
*Release Date - 1 September 2015*


== User Guide ==

1. After installation (as described above in the "Installation" section), go to the Settings page (Settings->Quizr Settings on the left-hand side
menu) and put in your Facebook App ID and/or Twitter handle. If you don't provide the IDs, you will be able to create quizzes, but
your users won't be able to share their results.

2. Create a new quiz: Quizzes->Add New on the left-hand side menu. Also take note of the quiz shortcode (in the form [wp_quizr id = "xx" columns = "x"]) that's shown on this
quiz-edit page; you will need to paste this later on the page or post in which you would like your quiz to be shown.

3. Give your new quiz a name.

4. Specify the number of final outcomes and the number of questions you would like this quiz to have. Click "Publish" so this information is saved. 
The "Titles of Outcomes" and "Titles Of Questions" fields will now be available for your input.

5. Specify the titles of your questions and outcomes. For the question fields you can choose to show your question as both an image and text, or you can show just one of these. You can do this by using the 
"Show Text For This Question?" drop-down menu. 

NB: If you choose not to show the question's text (only an image), please make sure to specify your question title's text, even though this text will not show on the quiz.

6.Click on "Update" to save this information. You will now be able to upload
the picture choices for each question and for the outcomes. Note that these fields will not show if the fields above them have not been completed.

7. Specify the details for each outcome. You can specify the Outcome image, its description as well as a url you may like to direct the user 
to if they click on the image. Each of these is optional.

8. Upload and specify the question images associated with each outcome. You may also choose to have an image that is not associated with any of your 
outcomes by clicking on the plus (+) sign to add an image. The final result depends on the number times the user chooses images associated with that particular outcome.

9. Paste the shortcode (available from the Quiz edit page) in a post or page. Note that if you don't specify the number of columns in the shortcode, 
the default number of columns (2) will be used.