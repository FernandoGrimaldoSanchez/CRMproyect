<?php die("Access Denied"); ?>#x#a:2:{s:6:"result";a:5:{i:0;O:8:"stdClass":3:{s:4:"link";s:53:"https://virtuemart.net/news/498-bugfix-release-3-6-10";s:5:"title";s:88:"Bugfix Release 3.6.10 Important fix for category restriction of payment/shipment plugins";s:11:"description";s:7201:"<p style="text-align: justify;"><img src="https://virtuemart.net/images/virtuemart/news/VirtueMart-Doors.jpg" alt="VirtueMart Doors" />When a release is just around the corner, we stop adding new features and focus on testing and fixing bugs. So it's a normal reaction of our members to push their wishes after the release. So this new core has an above-average number of new features for a subversion. There are mainly two different groups of features. Some are like furniture. It is quite simple to add them and it is very unlikely that they break something. It may happen that the new table stands in the way of the rarely used door to the basement. But it is simple to fix. Most of the time our testers catch these issues, but sometimes the central heating door was not tested. The new features are all of that kind. The worst which can happen is, that they do not work.</p>
<div class="special-download">
<p style="text-align: center;"><a class="button-primary" href="https://virtuemart.net/download">DOWNLOAD VM3 NOW<br /> VirtueMart 3 component (core and AIO)</a></p>
<p style="text-align: justify;">Bigger, more complex feature changes are done in the major versions such as VirtueMart 3.6. These feature changes are more similar to changing the room layout of a house, or adding an extra floor, or replacing the roof, and so on. These are changes which require much more testing and these are more likely to break other constructions attached to your house. For example, the beautiful balcony (your one-page checkout).</p>
<p style="text-align: justify;">Sometimes we notice that our house is not really comfortable. Displaying the order details below the order list was a good idea, but if the order list was too long then buyers did not see the order details. The order details open now above the list. This way, the logic makes much more sense. If you scroll down in the order details, you can directly select the next order. These and similar changes can be found below in the list of changed behaviors.</p>
<p style="text-align: justify;">One of them even starts with "fixed an issue editing the order...". This one is a very typical problem with the GUI, the graphical user interface. The difference of design and art. It sounds simple, but it is not easy to create a functional GUI. It is quite simple to create a nice looking GUI, but that only counts at first glance. In the long run, a GUI must work functionally. The whole order editing started as plain edit function without any assistance. When you changed a data, the new data was taken. A rough calculation system was added to help with the simple summation.<br /> <br />VirtueMart 3.6 extended the order editing assisting system. The tax change works by drop-down, but this system was not written for discounts. The problem here was to find an elegant GUI. For example, a VAT does not need to be overwritten. If you select a VAT, you expect a fail-proof calculation. But sometimes a discount is granted according to a certain rule or only as a result of a specific trade. As a result, changing a quantity of a discounted item did not change the discount according to the new quantity. The system accepted the discount the old way, as direct input.<br /> <br />The new system now works so, that the discount is always calculated by the given prices and multiplied by the quantity. However, if some of the required prices do not exist (for example, the undiscounted gross price), the discount value is transferred as direct input for the whole position. So you can still overwrite the discount by simply emptying the gross price. The GUI concepts follows the intuitive idea, that an empty price field is calculated by the existing data. So you can of course also just set the gross price and the discount and you will get your net and final price calculated automatically.</p>
<p style="text-align: justify;">Last but not least the bug-fixes. Sometimes it happens that a "furniture feature" turns out to be a roof changer ;-). The feature "automatic thumbnailing of the 'no image set' image" is one of these types. It led to a cascade of changes in the mediahandler.php file. The feature "remote images" remained silent in its corner and only caused problems there. But the simple sounding "automatic thumbnailing of the 'no image set' image" even caused problems when adding a new media because it suddenly behaved as thumbnail "no image set" image.<br />Sometimes a bugfix aggravates the problem. In German we use the word "verschlimmbessern", from "schlimm" (sad) and "bessern" (to make better). Test users reported that sometimes payment/shipment methods are not correctly selected in the cart, or not visible for selection. The provided fix solved the problem if categories were not set, but created another one. Adding the extra tests for the case 'on empty' lead to a wrongly used pattern and broke the category conditions.</p>
<p style="text-align: justify;">I hope that I gave a good insight how complex it is to deal with new features, bugs, features removing bugs, and bugfixes adding bugs, and so on.</p>
<p style="text-align: justify;">Thanks to our good community - join us at forum.virtuemart.net</p>
</div>
<h3>List of new features</h3>
<ul>
<li>Added placeholders to userfields</li>
<li>Added cloning of products with children</li>
<li>Added hidden config adminProductListBruttoPrices</li>
<li>Added option to user list in backend "show only shoppers"</li>
<li>Added vendor drop-down to users list in backend, so that it filters "shoppers of a vendor"</li>
<li>Added option to user account view "showUserShopperGrp"</li>
</ul>
<h3>Changed behaviour</h3>
<ul>
<li>Remote medias can now also be stored with http/s (is removed automatically)</li>
<li>Discontinued products are now only filtered for shoppers (not as managers in FE or BE)</li>
<li>Fixed an issue editing the order. Increasing the quantity of an item did not increase the given discount, but used the entered one. More information here&nbsp;<a class="external" href="http://forum.virtuemart.net/index.php?topic=143888.0" target="_blank" rel="noopener">http://forum.virtuemart.net/index.php?topic=143888.0</a></li>
<li>Order details are now opened above the order list</li>
<li>PayPal does not directly try to validate the data (for certain sub-methods), only when in checkout process</li>
<li>When ChangeShopperDeleteCart option is activated, then it also empties of the addresses of the current cart</li>
<li>If automatic payment/shipment is set to "none", the triggers are not executed</li>
</ul>
<h3>Enhancements</h3>
<ul>
<li>Component aio should work more robust now (some plugins prevented that it loaded the vmconfig correctly)</li>
<li>Added database key for product sku</li>
<li>Added delay of 400 ms to mediahandler autosearch function</li>
</ul>
<h3>List of fixes</h3>
<ul>
<li>Fix for no image display in media edit</li>
<li>Fixed category conditions for methods (shipment/payment)</li>
<li>Removed a note in router due a vmdebug</li>
<li>Fixed logic of storing username, when it is not allowed to change the username</li>
<li>Fix for adding new ST address in account maintenance view</li>
<li>Fixed typo in handle404 function</li>
</ul>";}i:1;O:8:"stdClass":3:{s:4:"link";s:76:"https://virtuemart.net/news/497-bugfix-release-3-6-8-registration-and-paypal";s:5:"title";s:53:"Bugfix Release 3.6.8 - Registration and PayPal issues";s:11:"description";s:2419:"<p style="text-align: justify;">An unexpected error occurred when updating to VirtueMart 3.6.4 using the All-in-One installer. The error was due to the uninitialized language object. First, we discovered that the VirtueMart files were loaded incorrectly when installing with third-party plug-ins present. But then all of a sudden, even with a completely new installation. The previous installation routine only checked whether the VmConfig class existed and executed the load configuration. The new installation routine also checks the existence of the vmLanguage class.<br /><br />And suddenly we had a problem with the PayPal IPN. If you google for the problem it is easy to see that it has been a periodically recurring problem. Our IPN function used the DNS records of the domains listed in the white list to check the IP. The new method uses a mixed mode and also checks if the requesting IP is resolved to the domains in the white list.</p>
<div class="special-download">
<p style="text-align: center;"><a class="button-primary" href="https://virtuemart.net/download">DOWNLOAD VM3 NOW<br /> VirtueMart 3 component (core and AIO)</a></p>
<p style="text-align: justify;">Update for 3.6.6: Some third-party developers only include our class VmConfig, but do not execute the loadConfig function. In other places, we check whether the VmConfig class already exists, and include <em>AND executed loadConfig</em> only if the class has not already been loaded. The router and the system plugin for updates now specifically check whether loadConfig has actually been executed.</p>
</div>
<h3>Changed behaviour</h3>
<ul>
<li>3.6.6 Invoice download icon is now a button with the invoice number</li>
<li>3.6.6 Backend order list search now considers order id and order total now (round by 2 digits)</li>
</ul>
<h3>List of fixes</h3>
<ul>
<li>3.6.6.2 Fix for AIO installer, ensuring a correctly initialised vm config</li>
<li>3.6.8 Fix for user registration in account view</li>
<li>3.6.8 fix for not loaded joomla language if user activation is used (double opt-in)</li>
<li>3.6.8 Virtuemart registration email now uses the joomla parameter "sendpassword" correctly</li>
<li>3.6.8 checkPaypalIps now works with a mixed mode. Thanks to Studio42 for this idea. <a href="http://forum.virtuemart.net/index.php?topic=131735.msg508782#msg508782">http://forum.virtuemart.net/index.php?topic=131735.msg508782#msg508782</a></li>
</ul>";}i:2;O:8:"stdClass":3:{s:4:"link";s:88:"https://virtuemart.net/news/496-bugfix-release-3-6-4-outdated-payment-plugins-work-again";s:5:"title";s:67:"Bugfix Release 3.6.4 - 3.6.6 Outdated payment plugins do work again";s:11:"description";s:4365:"<p>With all the improvements that were included in the release of VirtueMart 3.6.0 in late August 2019, we had also introduced new restriction parameters for payment plugins provided by the core. However, the new core introduced a small incompatibility for older payment plugins and some VirtueMart shop owners were unable to update their payment plugins to work with the new core. But the lively VirtueMart community found a way to get the old plugins working again. There was a lot of input in the development forum and many constructive talks. <strong>Great community work!</strong></p>
<div class="special-download">
<p style="text-align: center;"><a class="button-primary" href="https://virtuemart.net/download">DOWNLOAD VM3 NOW<br /> VirtueMart 3 component (core and AIO)</a></p>
<p style="text-align: justify;">Update for 3.6.6: Some 3rd party developer just include our class VmConfig, but do not execute the loadConfig function. At other places, we check if the VmConfig class already exists, and include AND executed loadConfig only when the class was not loaded already. The Router and the Systemplugin for updates check now specifically, if loadConfig was actually executed.</p>
</div>
<h3>List of new features</h3>
<ul>
<li>added shared_stock for child products. They can use now the stock of the parent</li>
<li>added feature "Disable inheriting of customfields to children"</li>
<li>Added an option for the menu item which allows shoppers to register themselves directly as vendors</li>
<li>added the possibility to manage shoppers per vendor for multivendor mode "byvendor"</li>
<li>Enabled routing of different languages within one call (vmLang must be set extra on the VmTable, because the table instance has its own temporarly&nbsp;vmLang var)</li>
<li>added automatic thumbnailing of the image which indicates that not image is set</li>
<li>3.6.6 joomla user activation features work for virtuemart again</li>
</ul>
<h3>Changed behaviour</h3>
<ul>
<li>edit order items, changing order status of one item does not automatically fire an order update any longer, use "edit ordered products" and store the order.</li>
<li>checkCaptcha ask a question to vendor uses now vm config ask_captcha</li>
<li>storing of user data stores now always the data to the cart.</li>
<li>Cart stores address after confirmOrder</li>
<li>browse view, it could happen that products did not show products, omitLoaded was not correctly set for the group "products"</li>
<li>browse view, changed order of loading of product groups to ensure that "featured products" are not already displayed among "products"</li>
<li>3.6.6 Invoice download icon is now a button with the invoicenumber</li>
<li>3.6.6 Backend order list, search considers order id and order total now (round by 2 digits)</li>
</ul>
<h3>List of fixes</h3>
<ul>
<li>changed cart so that it works&nbsp;correctly again with old payment/shipment plugins&nbsp;</li>
<li>rating replaced old preg_replace filter against FILTER_SANITIZE_STRING</li>
<li>Important fix for creditcard.php, new php versions threw notice</li>
<li>Updated js of the cart. There were double binds. The JS now binds only radios and checkboxes</li>
<li>PayPal fixed product price for overridden price</li>
<li>calculationHelper, fixed category restriction for rules per billcalculationHelper, fixed category restriction for rules per bill</li>
<li>edit order items should consider the coupon_code now</li>
<li>correct order created, modified date</li>
<li>fix for product browse when legacy mode is enabled</li>
<li>small fix for ids of calendars</li>
<li>models product fixed saveorder for storing ordering = 0</li>
<li>vmLoaderPluginUpdate updated language, xml</li>
<li>added fallback for reuseorders=1</li>
<li>changed getTip of config view.html.php it now uses the same fallbacks for rowShopFrontSet and writePriceConfigLine</li>
<li>getCurrentUrlBy, added mode for returning query as array (not as URI, string)</li>
<li>added parameter task to function call "manage" in function isSuperVendor</li>
<li>mordel orderstatus, function getOrderStatusNames set to static and returns more data</li>
<li>model orders replaced direct sql against static getOrderStatusNames</li>
<li>vmpsplugin.php, restrictions added empty checks for !is_array</li>
<li>3.6.6 (fix for 3.6.4 thumbnail of no image set image was rendered to root folder)</li>
</ul>";}i:3;O:8:"stdClass":3:{s:4:"link";s:56:"https://virtuemart.net/news/494-bugfix-release-for-3-6-0";s:5:"title";s:24:"Bugfix release for 3.6.0";s:11:"description";s:4753:"<p>Implemented new restriction parameters provided by the VirtueMart core to our native payment plugins PayPal, Amazon Pay, Sofort, Authorize.net, eWay, heidelPay, Klarna, Skrill, 2checkout and Realex The latter also received a general update and has been renamed to 'globalpayments' because it&nbsp; was acquired by Global Payments Inc. some time ago.. There is a slight change in the handling of pending orders. The new procedure is described here: <a href="https://docs.virtuemart.net/manual/general-concepts/215-checkout-process.html">https://docs.virtuemart.net/manual/general-concepts/215-checkout-process.html</a></p>
<div class="special-download">
<p style="text-align: center;"><a class="button-primary" href="https://virtuemart.net/download">DOWNLOAD VM3 NOW<br /> VirtueMart 3 component (core and AIO)</a></p>
<p style="text-align: center;">&nbsp;</p>
</div>
<h3>New Features</h3>
<ul>
<li>Added disabling of inherited related products and related categories</li>
<li>Customfields for shoppergroups</li>
<li>External media: Create thumbnails on the fly directly from remote server. Added extra permission for uploading remote media</li>
</ul>
<h3>enhanced or changed behaviour</h3>
<ul>
<li>Removed automatically selected ‘replace’ when selecting a media for upload</li>
<li>Removed keeping of customfield search filters when switching categories</li>
<li>Reconsidered the function deleteOldPendingOrder. The sql now always considers the time. New behaviour described here:<br /> <a href="https://docs.virtuemart.net/manual/general-concepts/215-checkout-process.html">https://docs.virtuemart.net/manual/general-concepts/215-checkout-process.html</a></li>
<li>Added message of missing/not writeable folder to the checkPath function</li>
<li>The customer_notified function now works only for the emails of the customer, the vendor email is always sent according to the orderstatus</li>
</ul>
<h3>Bugs</h3>
<ul>
<li>Fixed missing array key in getPayment</li>
<li>Fixed missing renderShipmentDropdown in shipment view</li>
<li>Taxes per bill were accidently not added to the shipment tax calculation</li>
<li>fixed overwrite prices in Paypal Express. Invalid token set the cart paymentmethod always to 0, even when paypal was not selected</li>
<li>Fixed creation of extra plugin tables of plugins textinput and specification</li>
<li>The vmplugin onStoreInstallPluginTable had replaced a $name against $this-&gt;name</li>
<li>Fixed breadcrumb for menu item pointing to productdetails. When menu item name and productname is the same, the productname is not written twice.</li>
<li>Added missing getDbo in state model (thx GJC)</li>
<li>Invoice view: Fixed foreach loop for the shipment address</li>
<li>Fixed a new (old) bug in order editing for the case discount before VAT</li>
</ul>
<h3>Completed</h3>
<ul>
<li>Added missing language</li>
<li>Updated vmprices.js so that it works also for quantity buttons in the cart (thank you Abhhishek)</li>
<li>Added country Montenegro</li>
<li>Safepath config model, added JPath clean before storing of the Path, added more check cases for wrong paths</li>
<li>Prices replaced init and step against data-init and data-step (the JS has a fallback)</li>
<li>Customer_notified works now only for the emails of the customer, the vendor email is always sent according to the orderstatus</li>
</ul>
<h3>Of Interest for developers</h3>
<ul>
<li>Important fix in cart helper function checkAutomaticSelectedPlug, the automaticSelected.type variable is now only set to true, if there is only one method.</li>
<li>Plugins using the core restriction remove automatically the xml vars with the same name. So we can easily write backward compatible payment/shipment plugins. Please read here&nbsp;<a href="http://docs.virtuemart.net/tutorials/development/240-important-adjustments-for-virtuemart-3-6.html">http://docs.virtuemart.net/tutorials/development/240-important-adjustments-for-virtuemart-3-6.html</a></li>
<li>In the vmdefines function defines, changed default from <em>site</em> to <em>0</em>, if 0 is used the appId is taken from joomla</li>
<li>Added resetting of categoryRecursed in router and category model before calling getCategoryRecurse removed unsed code</li>
<li>For the weight_countries shipment plugin, address type just by STsameAsBT only</li>
<li>For function getVendorCurrency added a fallback for empty vendorId and a vmTrace to find the problem <a href="http://forum.virtuemart.net/index.php?topic=141856.msg506893#msg506893">http://forum.virtuemart.net/index.php?topic=141856.msg506893#msg506893</a></li>
<li>Added function getSafePathFor, which gives and if applicable creates a path for a certain topic. Old function checkSafePath now creates automatically the invoice path</li>
</ul>";}i:4;O:8:"stdClass":3:{s:4:"link";s:62:"https://virtuemart.net/news/492-more-than-10000-committs-later";s:5:"title";s:34:"VirtueMart 3.6.0 is now available!";s:11:"description";s:12492:"<div class="special-download">
<p style="text-align: center;"><a class="button-primary" href="https://virtuemart.net/download">DOWNLOAD VM 3.6 NOW<br /> VirtueMart 3.6 component (core and AIO)</a></p>
</div>
<h2 style="text-align: justify;">More than 10000 commits later</h2>
<p style="text-align: justify;">With this version VirtueMart has exceeded the 10 000 code commits mark and approximately 150 commits have been integrated into VirtueMart since we released the last stable version of VirtueMart 3.4.x a while ago. In the meantime we have released some development and release candidate versions. Among the many improvements and small bug fixes, here are some of the more noteworthy changes:</p>
<h3 style="text-align: justify;">For Shop Owners</h3>
<p style="text-align: justify;">Enhancing the edit order feature was a very hard nut to crack and took much longer than expected. We did implement additional attributes like the "is Paid", which allows shop owners to see confirmed but unpaid orders, which is especially of interest for purchases on account and also for paid but refunded orders. There are also some features that will be rarely visible, e.g. an unpaid order for the order status "Refund" shows the message "not recommended" because unpaid and not yet delivered orders should simply be cancelled.</p>
<p style="text-align: justify;">The old function for displaying missing medias in the VirtueMart 'Media List', was just a filter over the loaded list. Previously it was only possible to search within the first 400 medias for missing ones. The problem here obviously was that the job can't be done just by an sql query. It must check the state of a media in the filesystem. So it was ‘impossible’ to list them on pages following the first one. The new function runs the query up to 1000 times, but stops when the first page is filled. Lets assume, the pagination is set to 30 and there are 500 missing medias within the first 30 000 medias, then it just displays the first 30. On the other hand, if the pagination is set to 400 and you have 399 missing media out of 400 000, you would see those missing 399 missing media.<br /><br />iStraxx donated a simplified version of their ‘Download Plugin’. It allows to download a file once. It is of course working with indirect links, which means the user gets a link pointing to the plugin and the plugin decides if the user gets a file.</p>
<h3 style="text-align: justify;">For Developers</h3>
<p style="text-align: justify;">Since we pay a lot of attention to the desires of plugin developers, shipment/payment methods can now use new restriction parameters provided by the core, which are very simple to implement. See our tutorial link for more details: <a href="https://docs.virtuemart.net/tutorials/development/236-update-payment-shipment-plugin-using-new-core-restrictions.html">https://docs.virtuemart.net/tutorials/development/236-update-payment-shipment-plugin-using-new-core-restrictions.html</a></p>
<p style="text-align: justify;">There is a major change in <em>vmAccess</em>. The new system checks for rights without checking a task only for admin/manager. When a task is given, it checks only for the task. The old system always checked against admin/manager plus given tasks.</p>
<p style="text-align: justify;">There are some new permissions and some have been removed. In the case of backend user input, the "vm.raw" and "vm.html" permission filters have been removed. We now use the Joomla validator for input.</p>
<p style="text-align: justify;">Spyros Petrakis added a nice feature: The category module can now be displayed using the menu seperator of joomla. Just use the desired menu and id as a class, for example&nbsp;mod_virtuemart_category-id.</p>
<h3 style="text-align: justify;">Future development</h3>
<p style="text-align: justify;">There are many ideas in the roadmap for VirtueMart. Currently we are working on a new frontend template with the very famous template developer "Virtueplanet" and a lot more is evolving in the background. At present we also need helping hands for the new backend template. Join our team! Becoming a team member is simple. Just demonstrate in our forum that you know what you are talking about and write a request here&nbsp;&nbsp;<a href="http://forum.virtuemart.net/index.php?board=139.0">http://forum.virtuemart.net/index.php?board=139.0</a></p>
<p style="text-align: justify;">Another idea is to make VirtueMart available for Wordpress users. We also need helping hands here. The idea is to use the Joomla libraries as much as possible, which is why we will also work on Joomla 4.</p>
<p style="text-align: justify;">Further ideas for the VirtueMart core are: Enhanced calculator, enhanced multichilds, enhanced display (more radios with images instead of dropdowns), adapting the joomla customfield system and so forth....</p>
<h3>Other changes</h3>
<h4>Shopowner:</h4>
<ul>
<li>new hidden config "hideEmptyCustomfields" hides empty customfields</li>
<li>search customfields, removed options of empty customfields</li>
<li>new switch "newBackendTemplate". Just add to the virtuemart.cfg <em>newBackendTemplate=1</em> to try the new backend template. Currently only the configuration view is updated.</li>
<li>translateable calculation rule names</li>
<li>vendor mail if order status changed has adjustable text per order status now COM_VIRTUEMART_MAIL_VENDOR_CONTENT_</li>
<li>removed storing of cart to table for normal cart calls</li>
<li>enhanced snippets.php for Searchengines</li>
<li>enhanced coupon listing,</li>
<li>added published to coupons</li>
<li>delivery address get automatically named with the zip and a random number</li>
<li>buttons for the add-to-cart popup</li>
<li>removed the second button group on top to avoid problems with captchas.</li>
<li>validateUserData, validation of the country/state works now also when the state is unpublished</li>
<li>fixed custom model, in case of wrong extension_id, updating now to the correct extension_id</li>
<li>attachment for emails: Very important fix, views are instances and so attached medias must be set to an empty array to prevent sending wrong attachments</li>
</ul>
<h5>Major updates for the cart</h5>
<ul>
<li>loading an old cart does not override already entered values</li>
<li>defaults are now correctly loaded not only into the fields but also into the cart address arrays</li>
<li>automatic selected ship/payment works now loading all available methods. Before it was only working if there was only one method left.</li>
<li>Fixed Paypal Smartbuttons</li>
<li>product added popup (padded.php) displays now actually added product amount (set in the cart helper)</li>
<li>product model, loading price should now consider the time offset correctly</li>
<li>removed dragndrop ordering for products, if there is more than one page (the js is not prepared for)</li>
<li>removed print view popup of invoices. It produced a different print, than by pdf.</li>
</ul>
<h4>Developer</h4>
<ul>
<li>new loading of Plugins to ensure correct execution sequence. In case of site, they are loaded directly in loadConfig. replaced JPluginHelper::importPlugin against VmConfig::importVMPlugins</li>
<li>Important fix for 404 handling to prevent loop when an unpublished category is browsed</li>
<li>fixed 404 in case controller was not found</li>
<li>moved the classes vmAccess, vmUri in extra files</li>
<li>moved Reporting/echo function in an own file</li>
<li>product model enhanced sql for omitted products</li>
<li>fixed json view for customplugins in edit customs, dropdowns were not correctly loaded and got stored with wrong default values</li>
<li>which lead to wrong default order status for some 3rd party plugins, therefor also a fix for the field orderstatus to load comma seperated default values correctly</li>
<li>new function getStrByAcl to get Strings from the Request by ACL</li>
<li>moved the price display of plugins in an own sublayout.</li>
<li>added new permission vm.user.editvendor, IMPORTANT the permission vm.user.editshop should be set for the shop owner respectivly the super admin only!</li>
<li>enhanced setStoreOwner function, which considers the multivendor configuration of the shop now</li>
<li>changed the initialising of the cart so, that it always loads the userfields with the default values first. Function prepareAddressFieldsInCart is now deprecated</li>
<li>extra checks in the table vmusers for user/vendor relation</li>
<li>replaced a continue in a switch against break for php7.3 compatibility</li>
<li>disabled loading of the jQuery framework from joomla completly if jQuery is disabled in the vm config (by Abhishek)</li>
<li>disabled loading of popup fancybox/facebox if jQuery is disabled (by Abhishek)</li>
<li>final update for TcPdf, <br /> a) updated paths, <br /> b) added an hint why there are no images and removed breaking rendering for missing images<br /> c) VmPdf got more error messages and should load the defines by itself, class VmVendorPDF is not anylonger wrapped in if(class_exists('TCPDF')){</li>
<li>replaced the file_get_contents against the modern JHttpFactory::getHttp</li>
<li>product details, fixed canonical URL of the parent product</li>
<li>address fields in the cart can now be initialized filled only with default values but without rendered html and js scripts</li>
<li>added variable to the cart, which keeps the values set by defaults to determine if a value is set by the user or the system</li>
<li>addJScript uses now the defer and async correctly again.</li>
<li>Important fix, related to svn 10005 and forum post <a href="http://forum.virtuemart.net/index.php?topic=141797.0-">http://forum.virtuemart.net/index.php?topic=141797.0-</a> Important fix, related to svn 10005 and forum post <a href="http://forum.virtuemart.net/index.php?topic=141797.0This">http://forum.virtuemart.net/index.php?topic=141797.0This</a> time, a missing customfield is directly added as array to the variantmods array</li>
</ul>
<h4>For Templaters</h4>
<ul>
<li>Invoice view, the address fields are now directly accessible, for example with&nbsp;echo $this-&gt;userfields['BT']['email']</li>
</ul>
<h5>Performance optimisations</h5>
<ul>
<li>userfield model country field, replaced direct sql by VmTableCountry (getTable,...)</li>
<li>payment/shipment methods, added cache and own function for getting shoppergroups. This prevents one call per plugin n the cart.</li>
<li>VmPlugin, added important cache for function selectedThisByMethodId</li>
<li>getPluginMethods is cached</li>
<li>router is now using the same parameters as used for product browsing, which saves again a lot sql (products are not extra loaded for router!).</li>
<li>product model added cached function getCurrentUserShopperGrps, function getProduct finds the CurrentUserShopperGrps itself before it needed to be called before the getProduct function. Same function used in getProductSingle and getProducts!</li>
<li>enhanced the checkIfCached function, so the router can most time find an already loaded product</li>
<li>model customfields, enhanced also the cache of the function getCustomEmbeddedProductCustomFields</li>
<li>optimization for the functions getCountryByID and getCountryIDByName and the country model, loading a country creates directly multiple keys for the cached entry.</li>
<li>added important improvement, removed random in sql, the randomizing of products is done by loading more than needed an array_shuffle</li>
<li>router uses now also the cached Table class (reduced sql drastically)</li>
<li>added autohashing of tables (if set in the constructor)</li>
<li>model userfields replaced single requests in function getIfRequired against one but cached request.</li>
<li>Fixed caching in customfields model, loading a product twice with different quantities loaded the customfields plus the cached ones</li>
<li>Caching in model state functions getStates and testStateCountry</li>
<li>Caching in mediahandler function getIcon</li>
<li>getVmPluginMethod set false as default for parameter cache</li>
</ul>
<p>...and many other minor features, fixes, corrections. See the complete list of commits at <a href="http://dev.virtuemart.net/projects/virtuemart/repository">http://dev.virtuemart.net/projects/virtuemart/repository</a></p>
<div class="special-download">
<p style="text-align: center;"><a class="button-primary" href="https://virtuemart.net/download">DOWNLOAD VM 3.6 NOW<br /> VirtueMart 3.6 component (core and AIO)</a></p>
</div>";}}s:6:"output";s:0:"";}