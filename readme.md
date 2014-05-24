# MODX MaxCDN Toolkit

## Introduction
The MODX MaxCDN Toolkit provides the necessary elements to dynamically integrate MaxCDN with MODX. There are three elements to the toolkit:

* __Rules Manager__: The Rules Manager allows for frontend rules to be specified via a regular expression syntax. These rules will allow the targetted link structures (such as src attributes) to be rewritten to point to your CDN URL.
* __MaxCDN Linker Plugin__: The MaxCDN Linker plugin accesses the rules specified in the Rules Manager and dynamically rewrites the link structures on the frontend. See the Selective Caching section below.
* __MaxCDN Manager Plugin__: The MaxCDN Manager plugin provides advanced manager integration. It is only applicable if you are using a MaxCDN Enterprise plan and are utilising the full-page caching implementation (covered below in the Full-Page Caching section). By default, this is disabled on install due to it's specific usage requirements.

## Pre-Requisites
The following pre-requisites are required prior to installation:

* You have signed up for MaxCDN and configured your pull zone
	* Signup here: http://www.maxcdn.com/pricing/
    * Configure a pull zone: http://support.maxcdn.com/howto/create-a-pull-zone/
* You have created an API application within MaxCDN's control panel
	* Get an API Key/Secret pair: http://support.maxcdn.com/tutorials/create-an-api-idkey-pair/
* PHP 5.3 or above

## Installation
On installation of the MaxCDN component, have the following pieces of information available to expedite the setup:

* Your Pull Zone ID
* Your Company Alias
* Your Consumer Key/Secret pair
* Your default CDN URL (the MaxCDN generated CDN URL, xxx.yyy.netdna.com)

__Note: It is recommended that you initially select the _disabled_ option on install otherwise the MaxCDN Linker plugin will be immediately active which may not be desired. Once the component is installed, you can check settings, make any configuration or rule changes and then enable the MaxCDN integration.__ 

## Difference between CDN Strategies
### Selective CDN Caching

Selective caching is where you specifically target certain frontend static assets normally served from your site's domain to be served from the CDN domain instead. The MODX MaxCDN Toolkit supports this approach via a combination of the Rules Manager and the MaxCDN Linker plugin.

With the Rules Manager, you can either use the default rules (which should satisfy most use cases) or you can be more specific with custom rules, for example, only CDN caching assets in a certain folder or with a certain extension. These rules are applied against content types and can be applied to specific contexts for even granular targeting of assets.

See the section on Basic CDN Sharding to see how custom rules can be used to improve your site's frontend loading performance beyond the advantages already given by caching through MaxCDN.

#### Default Rules
For the purpose of documentation or if you do not select the 'Install Default Rules' option on install and later decide you want to use them, here are the default rules shipped with the MODX MaxCDN Toolkit:

__1. Site URL src and href links__

Replace src and href links that start with the site URL.

Input Rule: ``((?:src|href)=")({site_url})(.*\.(?:jpe?g|png|gif|ttf|otf|svg|woff|xml|js|css)")``
Output Format: ``{match1}{cdn_url}{match3}``

__2. Base URL src and href links__

Replace src and href links that start with the base URL.

Input Rule: ``((?:src|href)=")({base_url})(.*\.(?:jpe?g|png|gif|ttf|otf|svg|woff|xml|js|css)")``
Output Format: ``{match1}{cdn_url}{match3}``

__3. Relative URL src and href links__

Replace relative src and href links.

Input Rule: ``((?:src|href)=")(?!(?:https?|/))(.*\.(?:jpe?g|png|gif|ttf|otf|svg|woff|xml|js|css)")``
Output Format: ``{match1}{cdn_url}{match2}``

### Full-Page Caching

Full-page caching is a different configuration and requires a MaxCDN Enteprise plan. In a full-page caching scenario, you would configure you pull zone as such:

1. Create an A Record, origin.example.com that points to the IP of your site.
2. Configure your web server, if needed, to route the domain to your MODX install.
3. Create your pull zone, add origin.example.com as your Origin URL and add your site's domain as a custom CDN domain.
4. Change your site's domain to a CNAME record that points to the default CDN URL provided by MaxCDN, xxx.yyy.netdna.com.
5. Allow time for the DNS changes to propagate but then your site should be getting served via MaxCDN.
6. Install [microcache](https://github.com/opengeek/microcache/) to allow cache headers be set for your MODX resources.
7. Disable the MaxCDN Linker plugin and enable the MaxCDN Manager plugin, this will provide an additional button when saving resources that will you to save and then send a purge request to MaxCDN for that particular MODX resource. The MaxCDN Manager plugin will also allow a full purge request to be sent to MaxCDN when the 'Clear Cache' menu option is chosen in the MODX Manager.


## Basic CDN Sharding
CDN sharding is a method whereby assets are served from several different CDN URLs to allow more concurrent requests to be handled by the browser thus resulting in quicker page load times. Although the CDN sharding capabilities are to be expanded on in future releases, you can still implement CDN sharding by file extension (or specific asset folder) with the curent Rules Manager.

First, you will need to make sure you have several alternative CDN URLs specified in the MaxCDN Control Panel. Then, you can create rules to target by, for example, file extension - you can use the default rules as a basis for doing this. For each rule you create, you can assign a different CDN URL that will be used. You could have JS files from cdn1.example.com, CSS from cdn2.example.com and images from cdn3.example.com.

__Note: If you are using the full-page caching strategy, you can still use the Rules Manager to do basic CDN sharing, just make sure you have the MaxCDN Linker plugin enabled.__

## SSL Support

SSL Support is coming soon.
