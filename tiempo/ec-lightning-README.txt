The ec-lightning.php script was added to the Canada template on 15-Oct-2016.

It uses the ./radar/ directory for caching (like the ec-radar.php script) and includes the following:

./radar/legendLightning.png  - legend 'dot' image
ec-lightning.php  - main script
ec-lightning-cachetest.php - testing script for cache, legend image, PHP and GD readiness
wxeclightning.php - display page.

Upload those 4 files to the appropriate directories on your Saratoga Base-Canada website.

In your Settings.php, add one entry:

$SITE['eclightningID'] = '@@@';

where @@@ can be the following lightningID entries: NAT ARC PAC WRN ONT QUE ATL

That will automatically customize the display in wxeclightning.php for your selected lightning map.

In your flyout-menu.xml add a new entry:

    <item caption="Lightning Advisory" link="wxeclightning.php" 
	title="Lightning Advisory Map from Environment Canada" />


in your language-fr.txt add the translations for:

langlookup|Lightning Advisory Map from Environment Canada|Lightning Advisory Map from Environment Canada|
langlookup|Lightning Advisory|Lightning Advisory|


