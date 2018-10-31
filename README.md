# Gutenberg Translation Patch

**Patch** the **missing code** and **shared translations** in Gutenberg file gutenberg.php for a better understanding of the meaning.

> This **patch** is **translated in 29 languages** and **others 11 in becoming** (help me in your lang) see translation section.

Because the "WordPress Plugin Directory" don't generally accept "patch as plugin" and not for translations, I decided to publish it only on my GitHub, and open an official issue https://github.com/WordPress/gutenberg/issues/11120/ on the Gutenberg development page: now all the polyglots can translate these strings "separately" according to their local language, and polyglots directions https://wordpress.slack.com/archives/C02RP50LK/p1540361456000100/

**Compatibility**:
- Gutenberg 4.2+
- Classic Editor 0.5
- WordPress 5.0-beta2
- WordPress 4.9+
- WordPress 5.1-alpha
- WordPress Branche (src) 5.0-alpha development
- WordPress Trunk (src) 5.1-alpha development

**Describe the bug**: -- _Updated 2018-10-28_

_The behavior description:_
- **Missing** the **translation string code**, in script of function "gutenberg_replace_default_add_new_button" in file gutenberg.php:461.
- The **translation strings code**, in script of function "gutenberg_replace_default_add_new_button" in file gutenberg.php:312 and gutenberg.php:462 are **shared**.

> This **Bug** _and this patch (for now)_ are **related to Gutenberg Plugin** and **not to WordPress** because the code in question has not yet been imported in core.

**To Reproduce**:

_Steps to reproduce the behavior:_
- The **string "Gutenberg"** in file gutenberg.php:461 is **not translatable**.
- The **strings** gutenberg.php:312 and gutenberg.php:462 **share same translation but is preferable separate translations**.

**Expected behavior**:

_Steps to fix the behavior:_
- **Add missed translation code string** `<?php echo esc_js( __( 'Gutenberg', 'gutenberg' ) ); ?>` on script in function gutenberg_replace_default_add_new_button file gutenberg.php:461
- **Separate translation of shared strings** on script in function gutenberg_replace_default_add_new_button file gutenberg.php:312 and gutenberg.php:462

**Translation**:

I have add the gutenberg-translation-patch.pot file that it can be used with PoEdit to generate the local translation langs.

Some translations was add on distribution file, and more others are coming soon.

Included Translations:

- de_CH - German Switzerland
- de_DE - German
- en_AU - English Australian
- en_CA - English Canada
- en_NZ - English New Zealand
- en_ZA - English South Africa
- en_GB - English UK
- en_US - English US
- es_ES - Spanish Spain
- es_AR - Spanish Argentina
- es_CL - Spanish Chile
- es_CO - Spanish Colombia
- es_CR - Spanish Costa Rica
- es_VE - Spanish Venezuela
- es_GT - Spanish Guatemala
- es_MX - Spanish Mexico
- es_PE - Spanish Peru
- es_PR - Spanish Puerto Rico
- es_US - Spanish US
- fr_FR - French
- fr_BE - French Belgium
- fr_CA - French Canada
- it_IT - Italian
- lij_ZE - Ligurian Language (Genoese) LIJ
- pt_BR - Portuguese Brazil
- pt_PT - Portuguese Portugal

Coming Soon Translations:

- bal   - Catalan Balear (this refer to the islands)
- ca    - Catalan (Valencia is translated as Catalan)
- sv_SE - Swedish (partial translated) Help me for this!

I need translation help for this: (ping and send me on slack)

- Dansk
- Greek
- Nederland
- Nordish
- Polski
- Romana
- Slovencna
- Slovenscna
- Shqip
- Svenska
- Turke

**Screenshots**:

- https://github.com/luciano-croce/gutenberg-translation-patch/blob/master/screenshot-1.png
- https://github.com/luciano-croce/gutenberg-translation-patch/blob/master/screenshot-2.png
- https://github.com/luciano-croce/gutenberg-translation-patch/blob/master/screenshot-3.png
- https://github.com/luciano-croce/gutenberg-translation-patch/blob/master/screenshot-4.png

> The menu shown in the screenshots is added by the Gutenberg Plugin and not by the WordPress Core.
