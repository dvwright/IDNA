=== IDNA ===
Contributors: dwright
Donate link: http://dwright.us/misc/idna/
Tags: idn, i18n, punycode
Requires at least: 2.7
Tested up to: 3.0-beta2
Stable tag: 1.2.0

This plugin adds IDN support to Wordpress. IDN (Internationalized domain name) is a domain name that contains non-ascii characters.

== Description ==

This plugin adds IDN support to Wordpress, making it an IDNA application. An IDN is a domain name that contains non-ascii characters.
This plugin enables one to set the WordPress address (URL) to an IDN. (instead of the Punycode Representation)

Examples of an IDN:

* bücher.ch
* domæne.dk
* nörgler.com
* uddannelsesstøtte.dk
* müller.de
* räksmörgås.nu
* 画像.jp

> "An IDNA-enabled application is able to convert between the internationalised
> and ASCII representations of a domain name. It uses the ASCII form for DNS
> lookups but can present the internationalised form to users who presumably
> prefer to read and write domain names in non-ASCII scripts such as Arabic or
> Hiragana. Applications that do not support IDNA will not be able to handle
> domain names with non-ASCII characters, but will still be able to access such
> domains if given the (usually rather cryptic) ASCII equivalent." -
> [IDN entry at Wikipedia](http://en.wikipedia.org/wiki/Internationalized_domain_name)

In simple terms, this plugin allows one to set their blog url to an IDN.

If you are interested in seeing what the PUNYCODE version of your IDN is, here is an [online conversion tool](http://mct.verisign-grs.com/conversiontool/)

As an example:

> Frau Müller has a blog and wants to use the IDN, http://www.müller.de
> Currently, she would have to set the WP blog url, (General Settings menu) to 
> the Punycode version: *xn--mller-kva.de*, (which is the ascii representation
> of müller.de) this would allow users using a IDN aware web browser to access 
> the site using the desired url: http://www.müller.de
> (and also of course, xn--mller-kva.de). 
> 
> It is more convenient for Frau Müller to use the actual IDN
> http://www.müller.de as the WP blog url setting (General Settings menu), 
> this plugin enables that functionality.

There are a few caveats with using this plugin, depending on what Browser, Operating
System and versions used, one can get unexpected results.

Firefox >= 3.* 

Firefox supports IDN's but maintains a 'whitelist' of 'safe' domains.
.com, .net, .eu are not white listed for safety reasons, so IDN's on these
domains will display as Punycode.  [see bug: ](https://support.mozilla.com/en-US/forum/1/545827)

There is an new ('experimental') Firefox add-on, 
[IDN Navbar](https://addons.mozilla.org/en-US/firefox/addon/109224), which
will enable all (whitelisted - Punycode) domains to display as IDN's. 
So, if using Firefox and this plugin you (and your visitors) may want to install that addon.

Internet Explorer >= 7.* 

Depending on your language set up, site's that contain non 'native language'
characters will display as Punycode and not the IDN. More info
[msdn blogs](http://blogs.msdn.com/ie/archive/2006/07/31/684337.aspx)
[msdn libs1](http://msdn.microsoft.com/en-us/library/bb250505(VS.85).aspx)
[msdn libs2](http://msdn.microsoft.com/en-us/library/dd565654(VS.85).aspx)

Safari/Opera 10.* seem to display IDN's for all domain's fine. (untested)


== Installation ==

NOTE: This plugin requires PHP5

**See The Notes in: 'Other Notes' below before installing**

1. Point a web browser to [WP plugins](http://wordpress.org/extend/plugins/)

1. Search for **idna**, download and upload to your web host.

1. Copy the whole **idna** directory to the */wp-content/plugins/* directory of your WP blog

1. Access the administrative section of your WP blog. 
   (In a typical default installation, WP determines your hostname and sets the WP blog url field
   to the Punycode verion of your url, so you should be able to access the administrative section 
   of your WP blog using the Punycode version of the IDN) if that is not the case, you will first 
   have to set the blog Url to use the Punycode version of your IDN, so you
   can access the administrative section to activate the plugin.

1. To get the PUNYCODE version of your IDN, here is an [online conversion tool](http://mct.verisign-grs.com/conversiontool/)

1. Activate the plugin **IDNA** through the *Plugins* menu in WordPress

1. Change your WP Url to now use your IDN
   * Navigate to General Settings menu
   * set the WordPress address (URL) field to your IDN name (*)
   * set the Blog address (URL) field to your IDN name
   * Save Changes

1. If something does go wrong and you get locked out of the admin section, see
   the notes in 'Other Notes' (Arbitrary section), to regain access. 


* Unfortunely, for security reasons, current Firefox versions will display the Punycode
version and NOT the IDN. For more details,(and work around) 
see the 'Other Notes' Link (Arbitrary section - readme.txt).


== Arbitrary section ==

WP plugins have a 'stable tag' requirement for distribution, however, at this
time, I consider this plugin to be **Beta** quality at best.

**It is possible to lock your self out of the administrative section of your blog**

**NOTE** make sure you are using an IDN capable web browser when enabling this plugin.
[More](http://idn.icann.org/IDN-aware_software#Browsers)

**NOTE** Unfortunely, Current Firefox versions display the Punycode version and 
NOT the IDN. For more details, (and work around) see the 'Other Notes' Link 
(Arbitrary section - readme.txt)

IE7/8, Safari, Opera10 all display the actual IDN, Firefox (and Chrome)
navigation bar's display the IDN as Punycode. (i.e. www.xn--)

There are some security issues with multi-byte chars and phishing, so this is
Mozilla's current approach, this may change in the future, as some folks are not
happy about it.

https://bugzilla.mozilla.org/show_bug.cgi?id=542562
another related, one: https://bugzilla.mozilla.org/show_bug.cgi?id=354592


Because this plugin effects how you access your site, installation is slightly more 
involved than most plugins.

If you installing this plugin, I would recommend, if possible, that it is the 
first thing you do on your blog, before you add any content, just in case 
something goes wrong, this will minimize downtime.

**NOTE** If something goes wrong and you cant access the WP admin area after
changing your url, here are some instructions for 
[resetting your url](http://codex.wordpress.org/Changing_The_Site_URL)

*Please report any bugs you find to the author of this plugin*

== Frequently Asked Questions ==

**Q: What is an IDN? Do I need this plugin?**

A: If you don't know, you don't need it.

In a nutshell:
IDN is an abbrevation for "Internationalized Domain Name"

Internationalizing Domain Names in Applications (IDNA) is a mechanism defined
in 2003 for handling internationalised domain names containing non-ASCII
characters.

These names are typically written in languages or scripts which do not use the
Latin alphabet: Arabic, Hangul, Hiragana and Kanji for instance.

Read more, 
[IDN info at Wikipedia](http://en.wikipedia.org/wiki/Internationalized_domain_name)

**Q: Do you use a IDN library in this plugin?**

A: Yes, this one, [Php_Net_idna](http://freshmeat.net/projects/php_net_idna).
Many thanks to the author for their fine work on this great library!


**Q: My URL is an IDN in the .com space, how come Firefox show's http://xn-
then some characters that are not my IDN?**

That is the Punycode representation of your IDN. There is an new ('experimental')
Firefox add-on, [IDN Navbar](https://addons.mozilla.org/en-US/firefox/addon/109224),
which will display the IDN instead of Punycode. So, if using Firefox and this 
plugin you (and your visitors) may want to install that addon.


== Screenshots ==

1. General Settings Section. Illustrates using an IDN (in place of the
        Punycode representation)(If you tried setting the URL field to an IDN
            without this plugin, Saved it, then tried accessing your site, it
            would fail. (i.e. this screen shot proves the plugin works - for
                this IDN anyway,...)
2. Login to Admin area using the IDN (IDNA aware browsers would do the
        conversion anyway, so even if you are using the Punycode
        representation in 'General Settings', you could login using the IDN in
        the Browser Navigation bar. (i.e So this img doesn't actually prove anything)
3. Access the Dashboard area using the IDN (same note as point 2)
4. General Settings Section. Illustrates using another IDN (in place of the
    Punycode representation) (same note as 1)


== Changelog ==

= 1.2.0 = Beta Release
* bug fixes: creates invalid urls in RSS feeds (from Chris Ramey)

= 1.1.0 = Beta Release
* bug fixes: 404 on bulk actions, move to trash, empty trash (edit.php)

= 1.0.0 =

* I'm calling this a stable release for the 'stable tag' requirement, however, I haven't received enough feedback to actually consider it stable yet.

= 0.0.1 =

* Initial Release

== Upgrade Notice ==

