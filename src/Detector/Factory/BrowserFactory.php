<?php
/**
 * Copyright (c) 2012-2015, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Detector\Factory;

use BrowserDetector\Detector\Browser\A6Indexer;
use BrowserDetector\Detector\Browser\AbontiBot;
use BrowserDetector\Detector\Browser\Aboundexbot;
use BrowserDetector\Detector\Browser\AboutUsBot;
use BrowserDetector\Detector\Browser\AboutUsBotJohnny5;
use BrowserDetector\Detector\Browser\Acapbot;
use BrowserDetector\Detector\Browser\AccServer;
use BrowserDetector\Detector\Browser\AcoonBot;
use BrowserDetector\Detector\Browser\AdbeatBot;
use BrowserDetector\Detector\Browser\AddCatalog;
use BrowserDetector\Detector\Browser\AddThisRobot;
use BrowserDetector\Detector\Browser\Adidxbot;
use BrowserDetector\Detector\Browser\AdmantxPlatformSemanticAnalyzer;
use BrowserDetector\Detector\Browser\AdobeAIR;
use BrowserDetector\Detector\Browser\AdvBot;
use BrowserDetector\Detector\Browser\AhrefsBot;
use BrowserDetector\Detector\Browser\Airmail;
use BrowserDetector\Detector\Browser\AjaxSnapBot;
use BrowserDetector\Detector\Browser\Akregator;
use BrowserDetector\Detector\Browser\Alexabot;
use BrowserDetector\Detector\Browser\AlltopApp;
use BrowserDetector\Detector\Browser\AmazonCloudFront;
use BrowserDetector\Detector\Browser\AndroidDownloadManager;
use BrowserDetector\Detector\Browser\AndroidWebkit;
use BrowserDetector\Detector\Browser\AndroidWebView;
use BrowserDetector\Detector\Browser\Anonymizied;
use BrowserDetector\Detector\Browser\AnotherWebMiningTool;
use BrowserDetector\Detector\Browser\AntBot;
use BrowserDetector\Detector\Browser\AolBot;
use BrowserDetector\Detector\Browser\ApacheSynapse;
use BrowserDetector\Detector\Browser\Apercite;
use BrowserDetector\Detector\Browser\AppleAppStoreApp;
use BrowserDetector\Detector\Browser\AppleCoreMedia;
use BrowserDetector\Detector\Browser\AppleMail;
use BrowserDetector\Detector\Browser\ApplePubSub;
use BrowserDetector\Detector\Browser\ApusBrowser;
use BrowserDetector\Detector\Browser\ArachnidaWebCrawler;
use BrowserDetector\Detector\Browser\ArchiveBot;
use BrowserDetector\Detector\Browser\ArchiveOrgBot;
use BrowserDetector\Detector\Browser\Arora;
use BrowserDetector\Detector\Browser\AskPeterBot;
use BrowserDetector\Detector\Browser\Avant;
use BrowserDetector\Detector\Browser\BacklinkCrawler;
use BrowserDetector\Detector\Browser\BaiduBrowser;
use BrowserDetector\Detector\Browser\BaiduHdBrowser;
use BrowserDetector\Detector\Browser\BaiduMiniBrowser;
use BrowserDetector\Detector\Browser\BaiduMobileSearch;
use BrowserDetector\Detector\Browser\Bandscraper;
use BrowserDetector\Detector\Browser\Beamrise;
use BrowserDetector\Detector\Browser\BegunAdvertisingBot;
use BrowserDetector\Detector\Browser\BigBozz;
use BrowserDetector\Detector\Browser\Bingbot;
use BrowserDetector\Detector\Browser\BingPreview;
use BrowserDetector\Detector\Browser\BitlyBot;
use BrowserDetector\Detector\Browser\Blackberry;
use BrowserDetector\Detector\Browser\BlekkoBot;
use BrowserDetector\Detector\Browser\BlexBot;
use BrowserDetector\Detector\Browser\BloglovinBot;
use BrowserDetector\Detector\Browser\BlogSearch;
use BrowserDetector\Detector\Browser\BlogsharesSpiders;
use BrowserDetector\Detector\Browser\BlukLddcBot;
use BrowserDetector\Detector\Browser\BnfFrBot;
use BrowserDetector\Detector\Browser\BoardReaderFaviconFetcher;
use BrowserDetector\Detector\Browser\BotBot;
use BrowserDetector\Detector\Browser\Bot360;
use BrowserDetector\Detector\Browser\Bot80Legs;
use BrowserDetector\Detector\Browser\BotAraTurka;
use BrowserDetector\Detector\Browser\BotForJce;
use BrowserDetector\Detector\Browser\BotRevolt;
use BrowserDetector\Detector\Browser\Browsershots;
use BrowserDetector\Detector\Browser\Bubing;
use BrowserDetector\Detector\Browser\BuiBuiBot;
use BrowserDetector\Detector\Browser\BuSecurityProject;
use BrowserDetector\Detector\Browser\ButterflyRobot;
use BrowserDetector\Detector\Browser\CaCrawler;
use BrowserDetector\Detector\Browser\CareerBot;
use BrowserDetector\Detector\Browser\CarsAppBrowser;
use BrowserDetector\Detector\Browser\CcBot;
use BrowserDetector\Detector\Browser\CheckSiteVerificationAgent;
use BrowserDetector\Detector\Browser\Chedot;
use BrowserDetector\Detector\Browser\ChlooeBot;
use BrowserDetector\Detector\Browser\Chrome;
use BrowserDetector\Detector\Browser\Chromium;
use BrowserDetector\Detector\Browser\CitymapScreenshotService;
use BrowserDetector\Detector\Browser\Cliqzbot;
use BrowserDetector\Detector\Browser\CloudFlareAlwaysOnline;
use BrowserDetector\Detector\Browser\CmBrowser;
use BrowserDetector\Detector\Browser\CmsCrawler;
use BrowserDetector\Detector\Browser\CocCocBot;
use BrowserDetector\Detector\Browser\CocCocBrowser;
use BrowserDetector\Detector\Browser\ComodoDragon;
use BrowserDetector\Detector\Browser\ComodoIceDragon;
use BrowserDetector\Detector\Browser\ComodoSpider;
use BrowserDetector\Detector\Browser\ContextadBot;
use BrowserDetector\Detector\Browser\CookieReportsBot;
use BrowserDetector\Detector\Browser\CourseraMobileApp;
use BrowserDetector\Detector\Browser\Crawler;
use BrowserDetector\Detector\Browser\Crawler007AC9;
use BrowserDetector\Detector\Browser\Crawler4j;
use BrowserDetector\Detector\Browser\CrawlRobot;
use BrowserDetector\Detector\Browser\CrazyBrowser;
use BrowserDetector\Detector\Browser\Crazywebcrawler;
use BrowserDetector\Detector\Browser\CrowsnestMobileApp;
use BrowserDetector\Detector\Browser\Curl;
use BrowserDetector\Detector\Browser\Cyberduck;
use BrowserDetector\Detector\Browser\CybEye;
use BrowserDetector\Detector\Browser\Dalvik;
use BrowserDetector\Detector\Browser\Daumoa;
use BrowserDetector\Detector\Browser\DawinciAntiplagSpider;
use BrowserDetector\Detector\Browser\Dbot;
use BrowserDetector\Detector\Browser\DeepnetExplorer;
use BrowserDetector\Detector\Browser\Diffbot;
use BrowserDetector\Detector\Browser\DiggBot;
use BrowserDetector\Detector\Browser\Diglo;
use BrowserDetector\Detector\Browser\Dillo;
use BrowserDetector\Detector\Browser\DiscoverEd;
use BrowserDetector\Detector\Browser\DiscoveryBot;
use BrowserDetector\Detector\Browser\Dolfin;
use BrowserDetector\Detector\Browser\DolphinSmalltalkHttpClient;
use BrowserDetector\Detector\Browser\DomainAppenderBot;
use BrowserDetector\Detector\Browser\DomainsBot;
use BrowserDetector\Detector\Browser\DomainScanServerMonitoring;
use BrowserDetector\Detector\Browser\DomainSigmaCrawler;
use BrowserDetector\Detector\Browser\Domnutch;
use BrowserDetector\Detector\Browser\DoradoWapBrowser;
use BrowserDetector\Detector\Browser\DotBot;
use BrowserDetector\Detector\Browser\DoubanApp;
use BrowserDetector\Detector\Browser\DownloadAccelerator;
use BrowserDetector\Detector\Browser\Dreamweaver;
use BrowserDetector\Detector\Browser\DuckDuckFaviconsBot;
use BrowserDetector\Detector\Browser\EasouSpider;
use BrowserDetector\Detector\Browser\EbApp;
use BrowserDetector\Detector\Browser\Eccp;
use BrowserDetector\Detector\Browser\ElementBrowser;
use BrowserDetector\Detector\Browser\ElluminateLive;
use BrowserDetector\Detector\Browser\ElmediaPlayer;
use BrowserDetector\Detector\Browser\Elmer;
use BrowserDetector\Detector\Browser\Embedly;
use BrowserDetector\Detector\Browser\Entireweb;
use BrowserDetector\Detector\Browser\Epiphany;
use BrowserDetector\Detector\Browser\EspialTvBrowser;
use BrowserDetector\Detector\Browser\Esribot;
use BrowserDetector\Detector\Browser\EventMachineHttpClient;
use BrowserDetector\Detector\Browser\EvernoteClipResolver;
use BrowserDetector\Detector\Browser\EveryoneSocialBot;
use BrowserDetector\Detector\Browser\Exabot;
use BrowserDetector\Detector\Browser\Experibot;
use BrowserDetector\Detector\Browser\Ezooms;
use BrowserDetector\Detector\Browser\EzPublishLinkValidator;
use BrowserDetector\Detector\Browser\FacebookApp;
use BrowserDetector\Detector\Browser\FacebookExternalHit;
use BrowserDetector\Detector\Browser\Facebookscraper;
use BrowserDetector\Detector\Browser\FaceBot;
use BrowserDetector\Detector\Browser\FakeBrowser;
use BrowserDetector\Detector\Browser\FeedBlitz;
use BrowserDetector\Detector\Browser\FeeddlerRssReader;
use BrowserDetector\Detector\Browser\Feedly;
use BrowserDetector\Detector\Browser\FeedlyApp;
use BrowserDetector\Detector\Browser\Fennec;
use BrowserDetector\Detector\Browser\FhscanCore;
use BrowserDetector\Detector\Browser\FinderleinResearchCrawler;
use BrowserDetector\Detector\Browser\Firefox;
use BrowserDetector\Detector\Browser\Flipboard;
use BrowserDetector\Detector\Browser\FlipboardProxy;
use BrowserDetector\Detector\Browser\FlixsterApp;
use BrowserDetector\Detector\Browser\FlyFlow;
use BrowserDetector\Detector\Browser\Focuseekbot;
use BrowserDetector\Detector\Browser\ForumPoster;
use BrowserDetector\Detector\Browser\FrCrawler;
use BrowserDetector\Detector\Browser\FreeWebMonitoringSiteChecker;
use BrowserDetector\Detector\Browser\GarlikCrawler;
use BrowserDetector\Detector\Browser\Genderanalyzer;
use BrowserDetector\Detector\Browser\GgPeekBot;
use BrowserDetector\Detector\Browser\GidBot;
use BrowserDetector\Detector\Browser\GigablastOpenSource;
use BrowserDetector\Detector\Browser\GlBot;
use BrowserDetector\Detector\Browser\GoHttpClient;
use BrowserDetector\Detector\Browser\GoldfireServer;
use BrowserDetector\Detector\Browser\GomezSiteMonitor;
use BrowserDetector\Detector\Browser\GooBlog;
use BrowserDetector\Detector\Browser\GoogleAdsbotMobile;
use BrowserDetector\Detector\Browser\GoogleAdsenseSnapshot;
use BrowserDetector\Detector\Browser\GoogleAdwordsDisplayAdsWebRender;
use BrowserDetector\Detector\Browser\GoogleApp;
use BrowserDetector\Detector\Browser\Googlebot;
use BrowserDetector\Detector\Browser\GooglebotMobileBot;
use BrowserDetector\Detector\Browser\GoogleDesktop;
use BrowserDetector\Detector\Browser\GoogleHttpClientLibraryForJava;
use BrowserDetector\Detector\Browser\GoogleImageProxy;
use BrowserDetector\Detector\Browser\GoogleKeywordSuggestion;
use BrowserDetector\Detector\Browser\GooglePageSpeedInsights;
use BrowserDetector\Detector\Browser\GooglePlus;
use BrowserDetector\Detector\Browser\GoogleSiteVerification;
use BrowserDetector\Detector\Browser\GoogleStructuredDataTestingTool;
use BrowserDetector\Detector\Browser\GoogleWebPreview;
use BrowserDetector\Detector\Browser\GoogleWebSnippet;
use BrowserDetector\Detector\Browser\GoogleWirelessTranscoder;
use BrowserDetector\Detector\Browser\GosquaredThumbnailer;
use BrowserDetector\Detector\Browser\GrapeFx;
use BrowserDetector\Detector\Browser\GrapeshotCrawler;
use BrowserDetector\Detector\Browser\GroupHighBot;
use BrowserDetector\Detector\Browser\Gvfs;
use BrowserDetector\Detector\Browser\HgghPhantomjsScreenshoter;
use BrowserDetector\Detector\Browser\HivaBot;
use BrowserDetector\Detector\Browser\HrCrawler;
use BrowserDetector\Detector\Browser\HttpClient;
use BrowserDetector\Detector\Browser\HttpRequester;
use BrowserDetector\Detector\Browser\Httrack;
use BrowserDetector\Detector\Browser\HubSpotWebcrawler;
use BrowserDetector\Detector\Browser\HyperCrawl;
use BrowserDetector\Detector\Browser\Iball;
use BrowserDetector\Detector\Browser\IbmConnections;
use BrowserDetector\Detector\Browser\IbooksAuthor;
use BrowserDetector\Detector\Browser\IBrowser;
use BrowserDetector\Detector\Browser\Icab;
use BrowserDetector\Detector\Browser\Icarus6j;
use BrowserDetector\Detector\Browser\IccCrawler;
use BrowserDetector\Detector\Browser\Iceweasel;
use BrowserDetector\Detector\Browser\IchiroBot;
use BrowserDetector\Detector\Browser\IchiroMobileBot;
use BrowserDetector\Detector\Browser\IframelyBot;
use BrowserDetector\Detector\Browser\IisBot;
use BrowserDetector\Detector\Browser\ImplisenseBot;
use BrowserDetector\Detector\Browser\InagistUrlResolver;
use BrowserDetector\Detector\Browser\InfegyAtlasBot;
use BrowserDetector\Detector\Browser\InstagramApp;
use BrowserDetector\Detector\Browser\Installatron;
use BrowserDetector\Detector\Browser\Integrity;
use BrowserDetector\Detector\Browser\InternetArchiveSpecialArchiver;
use BrowserDetector\Detector\Browser\InternetSeer;
use BrowserDetector\Detector\Browser\IosDataaccessd;
use BrowserDetector\Detector\Browser\Ipv4Scan;
use BrowserDetector\Detector\Browser\Iridium;
use BrowserDetector\Detector\Browser\Iron;
use BrowserDetector\Detector\Browser\IscHeaderCollectorHandlers;
use BrowserDetector\Detector\Browser\IstellaBot;
use BrowserDetector\Detector\Browser\ItsScan;
use BrowserDetector\Detector\Browser\Itunes;
use BrowserDetector\Detector\Browser\Iweb;
use BrowserDetector\Detector\Browser\IzSearchBot;
use BrowserDetector\Detector\Browser\JamesBot;
use BrowserDetector\Detector\Browser\Jasmine;
use BrowserDetector\Detector\Browser\JavaStandardLibrary;
use BrowserDetector\Detector\Browser\Jeode;
use BrowserDetector\Detector\Browser\JigBrowserWeb;
use BrowserDetector\Detector\Browser\JobdiggerSpider;
use BrowserDetector\Detector\Browser\JobRoboter;
use BrowserDetector\Detector\Browser\JoobleBot;
use BrowserDetector\Detector\Browser\KamelioApp;
use BrowserDetector\Detector\Browser\Kazehakase;
use BrowserDetector\Detector\Browser\Kgbody;
use BrowserDetector\Detector\Browser\Kinza;
use BrowserDetector\Detector\Browser\Kkman;
use BrowserDetector\Detector\Browser\Kmail2;
use BrowserDetector\Detector\Browser\Kmeleon;
use BrowserDetector\Detector\Browser\KomodiaBot;
use BrowserDetector\Detector\Browser\Konqueror;
use BrowserDetector\Detector\Browser\Kontact;
use BrowserDetector\Detector\Browser\Kraken;
use BrowserDetector\Detector\Browser\Krakenjs;
use BrowserDetector\Detector\Browser\Kulturarw3;
use BrowserDetector\Detector\Browser\Larbin;
use BrowserDetector\Detector\Browser\Lbot;
use BrowserDetector\Detector\Browser\LibreOffice;
use BrowserDetector\Detector\Browser\Liebao;
use BrowserDetector\Detector\Browser\LightspeedSystemsCrawler;
use BrowserDetector\Detector\Browser\LightspeedSystemsRocketCrawler;
use BrowserDetector\Detector\Browser\LinkdexBot;
use BrowserDetector\Detector\Browser\LinkedInBot;
use BrowserDetector\Detector\Browser\LinkpadBot;
use BrowserDetector\Detector\Browser\Links;
use BrowserDetector\Detector\Browser\LinksCrawler;
use BrowserDetector\Detector\Browser\LinkStatsBot;
use BrowserDetector\Detector\Browser\LipperheySeoService;
use BrowserDetector\Detector\Browser\LivelapBot;
use BrowserDetector\Detector\Browser\LoadTimeBot;
use BrowserDetector\Detector\Browser\Locubot;
use BrowserDetector\Detector\Browser\LotusNotes;
use BrowserDetector\Detector\Browser\Ltx71;
use BrowserDetector\Detector\Browser\Luakit;
use BrowserDetector\Detector\Browser\LucidworksBot;
use BrowserDetector\Detector\Browser\Lynx;
use BrowserDetector\Detector\Browser\MailChimp;
use BrowserDetector\Detector\Browser\MailRu;
use BrowserDetector\Detector\Browser\MarketwireBot;
use BrowserDetector\Detector\Browser\MauiWapBrowser;
use BrowserDetector\Detector\Browser\Maxthon;
use BrowserDetector\Detector\Browser\MaxthonNitro;
use BrowserDetector\Detector\Browser\MeanpathBot;
use BrowserDetector\Detector\Browser\MegaIndexBot;
use BrowserDetector\Detector\Browser\MemoryBot;
use BrowserDetector\Detector\Browser\MerchantCentricBot;
use BrowserDetector\Detector\Browser\Mercury;
use BrowserDetector\Detector\Browser\MetaGeneratorCrawler;
use BrowserDetector\Detector\Browser\Metager2VerificationBot;
use BrowserDetector\Detector\Browser\MetaHeadersBot;
use BrowserDetector\Detector\Browser\MetaInspector;
use BrowserDetector\Detector\Browser\MetaJobBot;
use BrowserDetector\Detector\Browser\MetaUri;
use BrowserDetector\Detector\Browser\MicrosoftAccess;
use BrowserDetector\Detector\Browser\MicrosoftCryptoApi;
use BrowserDetector\Detector\Browser\MicrosoftEdge;
use BrowserDetector\Detector\Browser\MicrosoftExcel;
use BrowserDetector\Detector\Browser\MicrosoftFrontPage;
use BrowserDetector\Detector\Browser\MicrosoftInternetExplorer;
use BrowserDetector\Detector\Browser\MicrosoftLync;
use BrowserDetector\Detector\Browser\MicrosoftMobileExplorer;
use BrowserDetector\Detector\Browser\MicrosoftOffice;
use BrowserDetector\Detector\Browser\MicrosoftOfficeProtocolDiscovery;
use BrowserDetector\Detector\Browser\MicrosoftOfficeSyncProc;
use BrowserDetector\Detector\Browser\MicrosoftOfficeUploadCenter;
use BrowserDetector\Detector\Browser\MicrosoftOneNote;
use BrowserDetector\Detector\Browser\MicrosoftOutlook;
use BrowserDetector\Detector\Browser\MicrosoftPowerPoint;
use BrowserDetector\Detector\Browser\MicrosoftVisio;
use BrowserDetector\Detector\Browser\MicrosoftWebDav;
use BrowserDetector\Detector\Browser\MicrosoftWord;
use BrowserDetector\Detector\Browser\Midori;
use BrowserDetector\Detector\Browser\MignifyBot;
use BrowserDetector\Detector\Browser\MiuiBrowser;
use BrowserDetector\Detector\Browser\MixBot;
use BrowserDetector\Detector\Browser\MixrankBot;
use BrowserDetector\Detector\Browser\Mj12bot;
use BrowserDetector\Detector\Browser\MobileSafariUiWebView;
use BrowserDetector\Detector\Browser\ModelsBrowser;
use BrowserDetector\Detector\Browser\MojeekBot;
use BrowserDetector\Detector\Browser\MonoBot;
use BrowserDetector\Detector\Browser\Moozilla;
use BrowserDetector\Detector\Browser\Moreover;
use BrowserDetector\Detector\Browser\MosBookmarks;
use BrowserDetector\Detector\Browser\MosBookmarksLinkChecker;
use BrowserDetector\Detector\Browser\MotorolaInternetBrowser;
use BrowserDetector\Detector\Browser\Mozilla;
use BrowserDetector\Detector\Browser\MozillaCrawler;
use BrowserDetector\Detector\Browser\MsnBotMedia;
use BrowserDetector\Detector\Browser\MyInternetBrowser;
use BrowserDetector\Detector\Browser\Nagios;
use BrowserDetector\Detector\Browser\NaverMatome;
use BrowserDetector\Detector\Browser\Nbot;
use BrowserDetector\Detector\Browser\NerdyBot;
use BrowserDetector\Detector\Browser\NetEstateCrawler;
use BrowserDetector\Detector\Browser\NetFront;
use BrowserDetector\Detector\Browser\NetFrontLifeBrowser;
use BrowserDetector\Detector\Browser\NetFrontNx;
use BrowserDetector\Detector\Browser\NetLyzerFastProbe;
use BrowserDetector\Detector\Browser\Netscape;
use BrowserDetector\Detector\Browser\NetseerCrawler;
use BrowserDetector\Detector\Browser\NettioBot;
use BrowserDetector\Detector\Browser\NetzCheckBot;
use BrowserDetector\Detector\Browser\NewsBlurFeedFetcher;
use BrowserDetector\Detector\Browser\NewsFire;
use BrowserDetector\Detector\Browser\Nichrome;
use BrowserDetector\Detector\Browser\NikiBot;
use BrowserDetector\Detector\Browser\NokiaBrowser;
use BrowserDetector\Detector\Browser\NokiaProxyBrowser;
use BrowserDetector\Detector\Browser\Obot;
use BrowserDetector\Detector\Browser\OktaMobileApp;
use BrowserDetector\Detector\Browser\Omniweb;
use BrowserDetector\Detector\Browser\OneBrowser;
use BrowserDetector\Detector\Browser\OpenHoseBot;
use BrowserDetector\Detector\Browser\OpenOffice;
use BrowserDetector\Detector\Browser\OpenVulnerabilityAssessmentSystem;
use BrowserDetector\Detector\Browser\Openwave;
use BrowserDetector\Detector\Browser\OpenWebkitSharp;
use BrowserDetector\Detector\Browser\OpenWebSpider;
use BrowserDetector\Detector\Browser\Opera;
use BrowserDetector\Detector\Browser\OperaCoast;
use BrowserDetector\Detector\Browser\OperaMini;
use BrowserDetector\Detector\Browser\OperaMobile;
use BrowserDetector\Detector\Browser\OptimizerBot;
use BrowserDetector\Detector\Browser\OptivoNetHelper;
use BrowserDetector\Detector\Browser\OwaspSecretBrowser;
use BrowserDetector\Detector\Browser\OwlerBot;
use BrowserDetector\Detector\Browser\PadBot;
use BrowserDetector\Detector\Browser\PageFreezer;
use BrowserDetector\Detector\Browser\PagesInventoryBot;
use BrowserDetector\Detector\Browser\Palemoon;
use BrowserDetector\Detector\Browser\PaperLiBot;
use BrowserDetector\Detector\Browser\PdrlabsBot;
use BrowserDetector\Detector\Browser\PeeploScreenshotBot;
use BrowserDetector\Detector\Browser\Phantomas;
use BrowserDetector\Detector\Browser\PhantomBrowser;
use BrowserDetector\Detector\Browser\PhantomJs;
use BrowserDetector\Detector\Browser\PhantomJsBot;
use BrowserDetector\Detector\Browser\Photon;
use BrowserDetector\Detector\Browser\Php;
use BrowserDetector\Detector\Browser\PicmoleBot;
use BrowserDetector\Detector\Browser\Picsearchbot;
use BrowserDetector\Detector\Browser\Pingdom;
use BrowserDetector\Detector\Browser\PinterestApp;
use BrowserDetector\Detector\Browser\PiplBot;
use BrowserDetector\Detector\Browser\PlaystationBrowser;
use BrowserDetector\Detector\Browser\Please200Bot;
use BrowserDetector\Detector\Browser\Plus5Bot;
use BrowserDetector\Detector\Browser\PmozinfoOdpLinkChecker;
use BrowserDetector\Detector\Browser\Polaris;
use BrowserDetector\Detector\Browser\Powermarks;
use BrowserDetector\Detector\Browser\Prince;
use BrowserDetector\Detector\Browser\PrismaticApp;
use BrowserDetector\Detector\Browser\Prlog;
use BrowserDetector\Detector\Browser\Profiller;
use BrowserDetector\Detector\Browser\Proximic;
use BrowserDetector\Detector\Browser\ProxyGearPro;
use BrowserDetector\Detector\Browser\PubCrawler;
use BrowserDetector\Detector\Browser\PublicLibraryArchive;
use BrowserDetector\Detector\Browser\Puffin;
use BrowserDetector\Detector\Browser\PwBot;
use BrowserDetector\Detector\Browser\PythonRequests;
use BrowserDetector\Detector\Browser\QqBrowser;
use BrowserDetector\Detector\Browser\QqBrowserMini;
use BrowserDetector\Detector\Browser\Qt;
use BrowserDetector\Detector\Browser\QualidatorBot;
use BrowserDetector\Detector\Browser\QuickiWikiBot;
use BrowserDetector\Detector\Browser\QuickLook;
use BrowserDetector\Detector\Browser\QuoraApp;
use BrowserDetector\Detector\Browser\QupZilla;
use BrowserDetector\Detector\Browser\Qwantify;
use BrowserDetector\Detector\Browser\Qword;
use BrowserDetector\Detector\Browser\R6CommentReader;
use BrowserDetector\Detector\Browser\RamblerMail;
use BrowserDetector\Detector\Browser\RankFlex;
use BrowserDetector\Detector\Browser\Readability;
use BrowserDetector\Detector\Browser\RebelMouse;
use BrowserDetector\Detector\Browser\Redbot;
use BrowserDetector\Detector\Browser\RedditPicScraper;
use BrowserDetector\Detector\Browser\Rekonq;
use BrowserDetector\Detector\Browser\Restify;
use BrowserDetector\Detector\Browser\RevIpSnfoSiteAnalyzer;
use BrowserDetector\Detector\Browser\RmSnapKit;
use BrowserDetector\Detector\Browser\Rockmelt;
use BrowserDetector\Detector\Browser\RockyChatWorkMobile;
use BrowserDetector\Detector\Browser\Rss2Html;
use BrowserDetector\Detector\Browser\Ruby;
use BrowserDetector\Detector\Browser\Safari;
use BrowserDetector\Detector\Browser\SafeSearchMicrodataCrawler;
use BrowserDetector\Detector\Browser\SalesForceApp;
use BrowserDetector\Detector\Browser\Samsung;
use BrowserDetector\Detector\Browser\SamsungBrowser;
use BrowserDetector\Detector\Browser\SamsungWebView;
use BrowserDetector\Detector\Browser\Sandvox;
use BrowserDetector\Detector\Browser\SchoolwiresApp;
use BrowserDetector\Detector\Browser\ScrapyBot;
use BrowserDetector\Detector\Browser\ScreamingFrogSeoSpider;
use BrowserDetector\Detector\Browser\ScreenerBot;
use BrowserDetector\Detector\Browser\ScreenshotBot;
use BrowserDetector\Detector\Browser\Scrubby;
use BrowserDetector\Detector\Browser\SearchteqBot;
use BrowserDetector\Detector\Browser\SecondLiveClient;
use BrowserDetector\Detector\Browser\SecondLiveCommerceClient;
use BrowserDetector\Detector\Browser\SecureBrowser360;
use BrowserDetector\Detector\Browser\SecurepointContentFilter;
use BrowserDetector\Detector\Browser\SeeBot;
use BrowserDetector\Detector\Browser\SemanticBot;
use BrowserDetector\Detector\Browser\SemanticVisionsCrawler;
use BrowserDetector\Detector\Browser\SemrushBot;
use BrowserDetector\Detector\Browser\SeoDiver;
use BrowserDetector\Detector\Browser\Seokicks;
use BrowserDetector\Detector\Browser\Seoprofiler;
use BrowserDetector\Detector\Browser\SetLinksCrawler;
use BrowserDetector\Detector\Browser\SeznamBot;
use BrowserDetector\Detector\Browser\SeznamBrowser;
use BrowserDetector\Detector\Browser\SeznamScreenshotGenerator;
use BrowserDetector\Detector\Browser\Sharp;
use BrowserDetector\Detector\Browser\ShowyouBot;
use BrowserDetector\Detector\Browser\Shrook;
use BrowserDetector\Detector\Browser\Silk;
use BrowserDetector\Detector\Browser\SimplePie;
use BrowserDetector\Detector\Browser\Sistrix;
use BrowserDetector\Detector\Browser\SiteCon;
use BrowserDetector\Detector\Browser\SiteExplorer;
use BrowserDetector\Detector\Browser\Skyfire;
use BrowserDetector\Detector\Browser\Slackbot;
use BrowserDetector\Detector\Browser\SlackbotLinkExpanding;
use BrowserDetector\Detector\Browser\SmartsiteHttpClient;
use BrowserDetector\Detector\Browser\SmartViera;
use BrowserDetector\Detector\Browser\SmrfUrlExpander;
use BrowserDetector\Detector\Browser\SmtBot;
use BrowserDetector\Detector\Browser\SnkScreenshotBot;
use BrowserDetector\Detector\Browser\Socialradarbot;
use BrowserDetector\Detector\Browser\SoftListBot;
use BrowserDetector\Detector\Browser\SogouExplorer;
use BrowserDetector\Detector\Browser\SogouSpider;
use BrowserDetector\Detector\Browser\SogouWebSpider;
use BrowserDetector\Detector\Browser\SonyEricsson;
use BrowserDetector\Detector\Browser\SophoraLinkchecker;
use BrowserDetector\Detector\Browser\Spinn3rRssAggregator;
use BrowserDetector\Detector\Browser\Squzer;
use BrowserDetector\Detector\Browser\SreleaseBot;
use BrowserDetector\Detector\Browser\SsearchCrawler;
use BrowserDetector\Detector\Browser\Stagefright;
use BrowserDetector\Detector\Browser\SuperaramaComBot;
use BrowserDetector\Detector\Browser\SuperBird;
use BrowserDetector\Detector\Browser\SuperfeedrBot;
use BrowserDetector\Detector\Browser\SurveyBot;
use BrowserDetector\Detector\Browser\SynHttpClient;
use BrowserDetector\Detector\Browser\TelecaObigo;
use BrowserDetector\Detector\Browser\TestCrawler;
use BrowserDetector\Detector\Browser\TexisWebscript;
use BrowserDetector\Detector\Browser\TheOldReader;
use BrowserDetector\Detector\Browser\ThumbnailAgent;
use BrowserDetector\Detector\Browser\Thumbor;
use BrowserDetector\Detector\Browser\ThumbShotsDeBot;
use BrowserDetector\Detector\Browser\ThumbSniper;
use BrowserDetector\Detector\Browser\Thunderbird;
use BrowserDetector\Detector\Browser\TinEyeBot;
use BrowserDetector\Detector\Browser\TinyBrowser;
use BrowserDetector\Detector\Browser\TinyTinyRss;
use BrowserDetector\Detector\Browser\TonlineBrowser;
use BrowserDetector\Detector\Browser\TubeTv;
use BrowserDetector\Detector\Browser\TumblrApp;
use BrowserDetector\Detector\Browser\TwcSportsNet;
use BrowserDetector\Detector\Browser\TweetedTimesBot;
use BrowserDetector\Detector\Browser\TweetmemeBot;
use BrowserDetector\Detector\Browser\TwinglyRecon;
use BrowserDetector\Detector\Browser\TwitterApp;
use BrowserDetector\Detector\Browser\Typo3Linkvalidator;
use BrowserDetector\Detector\Browser\UcBrowser;
use BrowserDetector\Detector\Browser\UmBot;
use BrowserDetector\Detector\Browser\Unisterbot;
use BrowserDetector\Detector\Browser\UnityWebPlayer;
use BrowserDetector\Detector\Browser\UniversalFeedParser;
use BrowserDetector\Detector\Browser\UnknownBrowser;
use BrowserDetector\Detector\Browser\UrlAppendBot;
use BrowserDetector\Detector\Browser\UrlfilterDbCrawler;
use BrowserDetector\Detector\Browser\Vagabondo;
use BrowserDetector\Detector\Browser\VbulletinSeoBot;
use BrowserDetector\Detector\Browser\ViralvideochartBot;
use BrowserDetector\Detector\Browser\VisionUtils;
use BrowserDetector\Detector\Browser\Vivaldi;
use BrowserDetector\Detector\Browser\VkShare;
use BrowserDetector\Detector\Browser\VlcMediaPlayer;
use BrowserDetector\Detector\Browser\W3cI18nChecker;
use BrowserDetector\Detector\Browser\W3cUnicorn;
use BrowserDetector\Detector\Browser\W3cValidatorNuLv;
use BrowserDetector\Detector\Browser\WadavnSearchBot;
use BrowserDetector\Detector\Browser\WasaLiveBot;
use BrowserDetector\Detector\Browser\WaterFox;
use BrowserDetector\Detector\Browser\WaybackArchive;
use BrowserDetector\Detector\Browser\WbSearchBot;
use BrowserDetector\Detector\Browser\WdgHtmlValidator;
use BrowserDetector\Detector\Browser\WebClip;
use BrowserDetector\Detector\Browser\WebdeMailCheck;
use BrowserDetector\Detector\Browser\WebGlance;
use BrowserDetector\Detector\Browser\WebIndex;
use BrowserDetector\Detector\Browser\WebkitWebos;
use BrowserDetector\Detector\Browser\WebMasterAid;
use BrowserDetector\Detector\Browser\WebmasterCoffee;
use BrowserDetector\Detector\Browser\WebRingChecker;
use BrowserDetector\Detector\Browser\WebsiteExplorer;
use BrowserDetector\Detector\Browser\WebsiteThumbnailGenerator;
use BrowserDetector\Detector\Browser\WebTarantula;
use BrowserDetector\Detector\Browser\WebThumb;
use BrowserDetector\Detector\Browser\WeChatApp;
use BrowserDetector\Detector\Browser\WeseeAds;
use BrowserDetector\Detector\Browser\WeseeSearch;
use BrowserDetector\Detector\Browser\WeTabBrowser;
use BrowserDetector\Detector\Browser\Wget;
use BrowserDetector\Detector\Browser\WhatWebWebScanner;
use BrowserDetector\Detector\Browser\WhiteHatAviator;
use BrowserDetector\Detector\Browser\WindowsLiveMail;
use BrowserDetector\Detector\Browser\WindowsMediaPlayer;
use BrowserDetector\Detector\Browser\WindowsPhoneSearch;
use BrowserDetector\Detector\Browser\WindowsRssPlatform;
use BrowserDetector\Detector\Browser\WinHttpRequest;
use BrowserDetector\Detector\Browser\WiseNutSearchEngineCrawler;
use BrowserDetector\Detector\Browser\WkHtmltopdf;
use BrowserDetector\Detector\Browser\Wnmbot;
use BrowserDetector\Detector\Browser\WooRank;
use BrowserDetector\Detector\Browser\WordPress;
use BrowserDetector\Detector\Browser\WordPressApp;
use BrowserDetector\Detector\Browser\Woriobot;
use BrowserDetector\Detector\Browser\WorldwebheritageBot;
use BrowserDetector\Detector\Browser\WsrAgent;
use BrowserDetector\Detector\Browser\XingContenttabreceiver;
use BrowserDetector\Detector\Browser\XmlSitemapsGenerator;
use BrowserDetector\Detector\Browser\XoviBot;
use BrowserDetector\Detector\Browser\YaBrowser;
use BrowserDetector\Detector\Browser\YahooAdMonitoring;
use BrowserDetector\Detector\Browser\YahooApp;
use BrowserDetector\Detector\Browser\YahooLinkPreview;
use BrowserDetector\Detector\Browser\YahooMobileApp;
use BrowserDetector\Detector\Browser\YahooSlingstone;
use BrowserDetector\Detector\Browser\YahooSlurp;
use BrowserDetector\Detector\Browser\YandexBot;
use BrowserDetector\Detector\Browser\YioopBot;
use BrowserDetector\Detector\Browser\YisouSpider;
use BrowserDetector\Detector\Browser\ZendHttpClient;
use BrowserDetector\Detector\Browser\ZetakeyBrowser;
use BrowserDetector\Detector\Browser\Zitebot;
use BrowserDetector\Detector\Browser\ZmEu;
use BrowserDetector\Detector\Browser\ZollardWorm;
use BrowserDetector\Detector\Browser\Zookabot;
use BrowserDetector\Detector\Browser\ZumBot;
use Psr\Log\LoggerInterface;
use WurflCache\Adapter\AdapterInterface;
use UaMatcher\Os\OsInterface;

/**
 * Browser detection class
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class BrowserFactory
{
    /**
     * Gets the information about the rendering engine by User Agent
     *
     * @param string                               $agent
     * @param \UaMatcher\Os\OsInterface            $platform
     * @param \Psr\Log\LoggerInterface             $logger
     * @param \WurflCache\Adapter\AdapterInterface $cache
     *
     * @return \BrowserDetector\Detector\Browser\AbstractBrowser
     */
    public static function detect($agent, OsInterface $platform, LoggerInterface $logger, AdapterInterface $cache = null)
    {
        if (preg_match('/windows nt (7|8|9)/i', $agent)) {
            $browser = new FakeBrowser($agent, $logger);
        } elseif (preg_match('/(khtml like gecko)/i', $agent)) {
            $browser = new FakeBrowser($agent, $logger);
        } elseif (preg_match('/(os x \d{4,5}\)|like macos x)/i', $agent)) {
            $browser = new FakeBrowser($agent, $logger);
        } elseif (preg_match('/(x11; windows)/i', $agent)) {
            $browser = new FakeBrowser($agent, $logger);
        } elseif (preg_match('/(windows x86\_64|compatible\-)/i', $agent)) {
            $browser = new FakeBrowser($agent, $logger);
        } elseif (preg_match('/(app3lewebkit)/i', $agent)) {
            $browser = new FakeBrowser($agent, $logger);
        } elseif (preg_match('/Mozilla\/(6|7|8|9)/i', $agent)) {
            $browser = new FakeBrowser($agent, $logger);
        } elseif (preg_match('/Mozilla\/(4|5)\.0(\+|  )/', $agent)) {
            $browser = new FakeBrowser($agent, $logger);
        } elseif (preg_match('/Mozilla\/(4|5)\.0 \(;;/', $agent)) {
            $browser = new FakeBrowser($agent, $logger);
        } elseif (preg_match('/Mozilla\/(4|5)\.0 \(\)/', $agent)) {
            $browser = new FakeBrowser($agent, $logger);
        } elseif (preg_match('/reddit pic scraper/i', $agent)) {
            $browser = new RedditPicScraper($agent, $logger);
        } elseif (preg_match('/Mozilla crawl/', $agent)) {
            $browser = new MozillaCrawler($agent, $logger);
        } elseif (preg_match('/^Mozilla /', $agent)) {
            $browser = new FakeBrowser($agent, $logger);
        } elseif (preg_match('/Mozilla\/4\.0 \(compatible\;Android\;/', $agent)) {
            $browser = new FakeBrowser($agent, $logger);
        } elseif (preg_match('/^\[FBAN/i', $agent)) {
            $browser = new FacebookApp($agent, $logger);
        } elseif (preg_match('/^(\'|\"|\[|\]|\=|\\\x|\(|label\=|intel mac os x)/i', $agent)) {
            $browser = new FakeBrowser($agent, $logger);
        } elseif (preg_match('/applewebkit\/1\.1/i', $agent)) {
            $browser = new FakeBrowser($agent, $logger);
        } elseif (preg_match('/(mozila|mozilmozilla|mozzila)/i', $agent)) {
            $browser = new FakeBrowser($agent, $logger);
        } elseif (preg_match('/(ucbrowser|uc browser|ucweb)/i', $agent) && preg_match('/opera mini/i', $agent)) {
            $browser = new UcBrowser($agent, $logger);
        } elseif (preg_match('/(opera mini|opios)/i', $agent)) {
            $browser = new OperaMini($agent, $logger);
        } elseif (preg_match('/opera mobi/i', $agent)
            || (preg_match('/(opera|opr)/i', $agent) && preg_match('/(Android|MTK|MAUI)/', $agent))
        ) {
            $browser = new OperaMobile($agent, $logger);
        } elseif (preg_match('/(ucbrowser|uc browser|ucweb)/i', $agent)) {
            $browser = new UcBrowser($agent, $logger);
        } elseif (preg_match('/IC OpenGraph Crawler/', $agent)) {
            $browser = new IbmConnections($agent, $logger);
        } elseif (preg_match('/(opera|opr)/i', $agent)) {
            $browser = new Opera($agent, $logger);
        } elseif (false !== strpos($agent, 'iCab')) {
            $browser = new Icab($agent, $logger);
        } elseif (preg_match('/HggH PhantomJS Screenshoter/', $agent)) {
            $browser = new HgghPhantomjsScreenshoter($agent, $logger);
        } elseif (preg_match('/bl\.uk\_lddc\_bot/', $agent)) {
            $browser = new BlukLddcBot($agent, $logger);
        } elseif (preg_match('/phantomas/', $agent)) {
            $browser = new Phantomas($agent, $logger);
        } elseif (false !== strpos($agent, 'PhantomJS')) {
            $browser = new PhantomJs($agent, $logger);
        } elseif (false !== strpos($agent, 'YaBrowser')) {
            $browser = new YaBrowser($agent, $logger);
        } elseif (false !== strpos($agent, 'Kamelio')) {
            $browser = new KamelioApp($agent, $logger);
        } elseif (false !== strpos($agent, 'FBAV')) {
            $browser = new FacebookApp($agent, $logger);
        } elseif (false !== strpos($agent, 'ACHEETAHI')) {
            $browser = new CmBrowser($agent, $logger);
        } elseif (false !== strpos($agent, 'bdbrowser_i18n')) {
            $browser = new BaiduBrowser($agent, $logger);
        } elseif (false !== strpos($agent, 'bdbrowserhd_i18n')) {
            $browser = new BaiduHdBrowser($agent, $logger);
        } elseif (false !== strpos($agent, 'bdbrowser_mini')) {
            $browser = new BaiduMiniBrowser($agent, $logger);
        } elseif (false !== strpos($agent, 'Puffin')) {
            $browser = new Puffin($agent, $logger);
        } elseif (preg_match('/stagefright/', $agent)) {
            $browser = new Stagefright($agent, $logger);
        } elseif (false !== strpos($agent, 'SamsungBrowser')) {
            $browser = new SamsungBrowser($agent, $logger);
        } elseif (false !== strpos($agent, 'Silk')) {
            $browser = new Silk($agent, $logger);
        } elseif (false !== strpos($agent, 'coc_coc_browser')) {
            $browser = new CocCocBrowser($agent, $logger);
        } elseif (false !== strpos($agent, 'NaverMatome')) {
            $browser = new NaverMatome($agent, $logger);
        } elseif (preg_match('/FlipboardProxy/', $agent)) {
            $browser = new FlipboardProxy($agent, $logger);
        } elseif (false !== strpos($agent, 'Flipboard')) {
            $browser = new Flipboard($agent, $logger);
        } elseif (false !== strpos($agent, 'Seznam.cz')) {
            $browser = new SeznamBrowser($agent, $logger);
        } elseif (false !== strpos($agent, 'Aviator')) {
            $browser = new WhiteHatAviator($agent, $logger);
        } elseif (preg_match('/NetFrontLifeBrowser/', $agent)) {
            $browser = new NetFrontLifeBrowser($agent, $logger);
        } elseif (preg_match('/IceDragon/', $agent)) {
            $browser = new ComodoIceDragon($agent, $logger);
        } elseif (false !== strpos($agent, 'Dragon')) {
            $browser = new ComodoDragon($agent, $logger);
        } elseif (false !== strpos($agent, 'Beamrise')) {
            $browser = new Beamrise($agent, $logger);
        } elseif (false !== strpos($agent, 'Diglo')) {
            $browser = new Diglo($agent, $logger);
        } elseif (false !== strpos($agent, 'APUSBrowser')) {
            $browser = new ApusBrowser($agent, $logger);
        } elseif (false !== strpos($agent, 'Chedot')) {
            $browser = new Chedot($agent, $logger);
        } elseif (false !== strpos($agent, 'Qword')) {
            $browser = new Qword($agent, $logger);
        } elseif (false !== strpos($agent, 'Iridium')) {
            $browser = new Iridium($agent, $logger);
        } elseif (preg_match('/avant/i', $agent)) {
            $browser = new Avant($agent, $logger);
        } elseif (false !== strpos($agent, 'MxNitro')) {
            $browser = new MaxthonNitro($agent, $logger);
        } elseif (preg_match('/(mxbrowser|maxthon|myie)/i', $agent)) {
            $browser = new Maxthon($agent, $logger);
        } elseif (preg_match('/(superbird)/i', $agent)) {
            $browser = new SuperBird($agent, $logger);
        } elseif (false !== strpos($agent, 'TinyBrowser')) {
            $browser = new TinyBrowser($agent, $logger);
        } elseif (false !== strpos($agent, 'Chrome') && false !== strpos($agent, 'Version')) {
            $browser = new AndroidWebView($agent, $logger);
        } elseif (false !== strpos($agent, 'Safari')
            && false !== strpos($agent, 'Version')
            && false !== strpos($agent, 'Tizen')
        ) {
            $browser = new SamsungWebView($agent, $logger);
        } elseif (preg_match('/cybeye/i', $agent)) {
            $browser = new CybEye($agent, $logger);
        } elseif (preg_match('/RebelMouse/', $agent)) {
            $browser = new RebelMouse($agent, $logger);
        } elseif (preg_match('/firefox/i', $agent) && preg_match('/anonym/i', $agent)) {
            $browser = new Firefox($agent, $logger);
        } elseif (preg_match('/trident/i', $agent) && preg_match('/anonym/i', $agent)) {
            $browser = new MicrosoftInternetExplorer($agent, $logger);
        } elseif (preg_match('/(randomized|anonym)/i', $agent)) {
            $browser = new Anonymizied($agent, $logger);
        } elseif (preg_match('/Windows\-RSS\-Platform/', $agent)) {
            $browser = new WindowsRssPlatform($agent, $logger);
        } elseif (preg_match('/Trident\/BD6/', $agent)) {
            $browser = new FakeBrowser($agent, $logger);
        } elseif (preg_match('/MarketwireBot/', $agent)) {
            $browser = new MarketwireBot($agent, $logger);
        } elseif (!preg_match('/trident/i', $agent) && preg_match('/msie (8|9|10|11)/i', $agent)) {
            $browser = new FakeBrowser($agent, $logger);
        } elseif (preg_match('/trident\/4/i', $agent) && preg_match('/msie (9|10|11)/i', $agent)) {
            $browser = new FakeBrowser($agent, $logger);
        } elseif (preg_match('/trident\/5/i', $agent) && preg_match('/msie (10|11)/i', $agent)) {
            $browser = new FakeBrowser($agent, $logger);
        } elseif (preg_match('/trident\/6/i', $agent) && preg_match('/msie 11/i', $agent)) {
            $browser = new FakeBrowser($agent, $logger);
        } elseif (preg_match('/netscape/i', $agent) && preg_match('/msie/i', $agent)) {
            $browser = new FakeBrowser($agent, $logger);
        } elseif (preg_match('/msie (\d+)\.(\d+)/i', $agent, $matches)
            && isset($matches[1])
            && isset($matches[2])
            && $matches[1] > 5
            && $matches[2] != 0
        ) {
            $browser = new FakeBrowser($agent, $logger);
        } elseif (preg_match('/Mozilla\/4/', $agent) && preg_match('/Chrome/', $agent)) {
            $browser = new FakeBrowser($agent, $logger);
        } elseif (preg_match('/LSSRocketCrawler/', $agent)) {
            $browser = new LightspeedSystemsRocketCrawler($agent, $logger);
        } elseif (preg_match('/lightspeedsystems/i', $agent)) {
            $browser = new LightspeedSystemsCrawler($agent, $logger);
        } elseif (preg_match('/SL Commerce Client/', $agent)) {
            $browser = new SecondLiveCommerceClient($agent, $logger);
        } elseif (preg_match('/(IEMobile|WPDesktop|ZuneWP7|XBLWP7)/', $agent)) {
            $browser = new MicrosoftMobileExplorer($agent, $logger);
        } elseif (preg_match('/BingPreview/', $agent)) {
            $browser = new BingPreview($agent, $logger);
        } elseif (preg_match('/360Spider/', $agent)) {
            $browser = new Bot360($agent, $logger);
        } elseif (preg_match('/Outlook\-Express/', $agent)) {
            $browser = new WindowsLiveMail($agent, $logger);
        } elseif (preg_match('/Outlook/', $agent)) {
            $browser = new MicrosoftOutlook($agent, $logger);
        } elseif (preg_match('/microsoft office mobile/i', $agent)) {
            $browser = new MicrosoftOffice($agent, $logger);
        } elseif (preg_match('/Microsoft Office Protocol Discovery/', $agent)) {
            $browser = new MicrosoftOfficeProtocolDiscovery($agent, $logger);
        } elseif (preg_match('/excel/i', $agent)) {
            $browser = new MicrosoftExcel($agent, $logger);
        } elseif (preg_match('/powerpoint/i', $agent)) {
            $browser = new MicrosoftPowerPoint($agent, $logger);
        } elseif (preg_match('/Word/', $agent)) {
            $browser = new MicrosoftWord($agent, $logger);
        } elseif (preg_match('/OneNote/', $agent)) {
            $browser = new MicrosoftOneNote($agent, $logger);
        } elseif (preg_match('/Visio/', $agent)) {
            $browser = new MicrosoftVisio($agent, $logger);
        } elseif (preg_match('/Access/', $agent)) {
            $browser = new MicrosoftAccess($agent, $logger);
        } elseif (preg_match('/Lync/', $agent)) {
            $browser = new MicrosoftLync($agent, $logger);
        } elseif (preg_match('/Office SyncProc/', $agent)) {
            $browser = new MicrosoftOfficeSyncProc($agent, $logger);
        } elseif (preg_match('/Office Upload Center/', $agent)) {
            $browser = new MicrosoftOfficeUploadCenter($agent, $logger);
        } elseif (preg_match('/microsoft office/i', $agent)) {
            $browser = new MicrosoftOffice($agent, $logger);
        } elseif (preg_match('/Crazy Browser/', $agent)) {
            $browser = new CrazyBrowser($agent, $logger);
        } elseif (preg_match('/Deepnet Explorer/', $agent)) {
            $browser = new DeepnetExplorer($agent, $logger);
        } elseif (preg_match('/KKman/', $agent)) {
            $browser = new Kkman($agent, $logger);
        } elseif (preg_match('/Smartsite HTTPClient/', $agent)) {
            $browser = new SmartsiteHttpClient($agent, $logger);
        } elseif (preg_match('/trident/i', $agent)
            && preg_match('/rv\:/i', $agent)
            && !preg_match('/like/i', $agent)
        ) {
            $browser = new FakeBrowser($agent, $logger);
        } elseif (preg_match('/Mozilla\/5\.0.*\(.*Trident\/8\.0.*rv\:\d+\).*/', $agent)
            || preg_match('/Mozilla\/5\.0.*\(.*Trident\/7\.0.*rv\:11\.0.*\) like Gecko.*/', $agent)
            || preg_match('/Mozilla\/5\.0.*\(.*MSIE 10\.0.*Trident\/(6|7)\.0.*/', $agent)
            || preg_match('/Mozilla\/(4|5)\.0.*\(.*MSIE (9|8)\.0.*/', $agent)
            || preg_match('/Mozilla\/(4|5)\.0.*\(.*MSIE (7|6)\.0.*/', $agent)
            || preg_match('/Mozilla\/(4|5)\.0.*\(.*MSIE (5|4)\.\d+.*/', $agent)
            || preg_match('/Mozilla\/\d\.\d+.*\(.*MSIE (3|2|1)\.\d+.*/', $agent)
        ) {
            $browser = new MicrosoftInternetExplorer($agent, $logger);
        } elseif (false !== strpos($agent, 'Chromium')) {
            $browser = new Chromium($agent, $logger);
        } elseif (false !== strpos($agent, 'Iron')) {
            $browser = new Iron($agent, $logger);
        } elseif (preg_match('/midori/i', $agent)) {
            $browser = new Midori($agent, $logger);
        } elseif (preg_match('/Google Page Speed Insights/', $agent)) {
            $browser = new GooglePageSpeedInsights($agent, $logger);
        } elseif (preg_match('/(googleimageproxy|via ggpht\.com)/i', $agent)) {
            $browser = new GoogleImageProxy($agent, $logger);
        } elseif (preg_match('/(web\/snippet)/', $agent)) {
            $browser = new GoogleWebSnippet($agent, $logger);
        } elseif (preg_match('/(googlebot\-mobile)/i', $agent)) {
            $browser = new GooglebotMobileBot($agent, $logger);
        } elseif (preg_match('/Google Wireless Transcoder/', $agent)) {
            $browser = new GoogleWirelessTranscoder($agent, $logger);
        } elseif (preg_match('/Locubot/', $agent)) {
            $browser = new Locubot($agent, $logger);
        } elseif (preg_match('/(com\.google\.GooglePlus)/i', $agent)) {
            $browser = new GooglePlus($agent, $logger);
        } elseif (preg_match('/Google\-HTTP\-Java\-Client/', $agent)) {
            $browser = new GoogleHttpClientLibraryForJava($agent, $logger);
        } elseif (preg_match('/acapbot/i', $agent)) {
            $browser = new Acapbot($agent, $logger);
        } elseif (preg_match('/googlebot/i', $agent)) {
            $browser = new Googlebot($agent, $logger);
        } elseif (preg_match('/^GOOG$/', $agent)) {
            $browser = new Googlebot($agent, $logger);
        } elseif (preg_match('/viera/i', $agent)) {
            $browser = new SmartViera($agent, $logger);
        } elseif (preg_match('/Nichrome/', $agent)) {
            $browser = new Nichrome($agent, $logger);
        } elseif (preg_match('/Kinza/', $agent)) {
            $browser = new Kinza($agent, $logger);
        } elseif (preg_match('/Google Keyword Suggestion/', $agent)) {
            $browser = new GoogleKeywordSuggestion($agent, $logger);
        } elseif (preg_match('/Google Web Preview/', $agent)) {
            $browser = new GoogleWebPreview($agent, $logger);
        } elseif (preg_match('/Google-Adwords-DisplayAds-WebRender/', $agent)) {
            $browser = new GoogleAdwordsDisplayAdsWebRender($agent, $logger);
        } elseif (preg_match('/HubSpot Webcrawler/', $agent)) {
            $browser = new HubSpotWebcrawler($agent, $logger);
        } elseif (preg_match('/RockMelt/', $agent)) {
            $browser = new Rockmelt($agent, $logger);
        } elseif (preg_match('/ SE /', $agent)) {
            $browser = new SogouExplorer($agent, $logger);
        } elseif (preg_match('/ArchiveBot/', $agent)) {
            $browser = new ArchiveBot($agent, $logger);
        } elseif (preg_match('/Edge/', $agent)) {
            $browser = new MicrosoftEdge($agent, $logger);
        } elseif (preg_match('/diffbot/i', $agent)) {
            $browser = new Diffbot($agent, $logger);
        } elseif (preg_match('/vivaldi/i', $agent)) {
            $browser = new Vivaldi($agent, $logger);
        } elseif (preg_match('/LBBROWSER/', $agent)) {
            $browser = new Liebao($agent, $logger);
        } elseif (preg_match('/chrome\/(\d+)\.(\d+))/i', $agent, $matches)
            && isset($matches[1])
            && isset($matches[2])
            && $matches[1] >= 1
            && $matches[2] > 0
        ) {
            $browser = new ComodoDragon($agent, $logger);
        } elseif (preg_match('/(chrome|crmo|crios)/i', $agent)) {
            $browser = new Chrome($agent, $logger);
        } elseif (preg_match('/flyflow/i', $agent)) {
            $browser = new FlyFlow($agent, $logger);
        } elseif (preg_match('/(dolphin http client)/i', $agent)) {
            $browser = new DolphinSmalltalkHttpClient($agent, $logger);
        } elseif (preg_match('/(dolphin|dolfin)/i', $agent)) {
            $browser = new Dolfin($agent, $logger);
        } elseif (preg_match('/MicroMessenger/', $agent)) {
            $browser = new WeChatApp($agent, $logger);
        } elseif (preg_match('/MQQBrowser\/Mini/', $agent)) {
            $browser = new QqBrowserMini($agent, $logger);
        } elseif (preg_match('/MQQBrowser/', $agent)) {
            $browser = new QqBrowser($agent, $logger);
        } elseif (preg_match('/Arora/', $agent)) {
            $browser = new Arora($agent, $logger);
        } elseif (preg_match('/com\.douban\.group/i', $agent)) {
            $browser = new DoubanApp($agent, $logger);
        }  elseif (preg_match('/ovibrowser/i', $agent)) {
            $browser = new NokiaProxyBrowser($agent, $logger);
        }  elseif (preg_match('/MiuiBrowser/i', $agent)) {
            $browser = new MiuiBrowser($agent, $logger);
        }elseif (preg_match('/ibrowser/i', $agent)) {
            $browser = new IBrowser($agent, $logger);
        } elseif (preg_match('/OneBrowser/', $agent)) {
            $browser = new OneBrowser($agent, $logger);
        } elseif (preg_match('/http:\/\/www\.baidu\.com\/search/', $agent)) {
            $browser = new BaiduMobileSearch($agent, $logger);
        } elseif (preg_match('/(yjapp|yjtop)/i', $agent)) {
            $browser = new YahooApp($agent, $logger);
        } elseif (preg_match('/(linux; u; android|linux; android)/i', $agent) && preg_match('/version/i', $agent)) {
            $browser = new AndroidWebkit($agent, $logger);
        } elseif (preg_match('/safari/i', $agent) && 'Android' === $platform->getName()) {
            $browser = new AndroidWebkit($agent, $logger);
        } elseif (preg_match('/Browser\/AppleWebKit/', $agent)) {
            $browser = new AndroidWebkit($agent, $logger);
        } elseif (preg_match('/Android\/[\d\.]+ release/', $agent)) {
            $browser = new AndroidWebkit($agent, $logger);
        } elseif (false !== strpos($agent, 'BlackBerry') && false !== strpos($agent, 'Version')) {
            $browser = new Blackberry($agent, $logger);
        } elseif (preg_match('/(webOS|wOSBrowser|wOSSystem)/', $agent)) {
            $browser = new WebkitWebos($agent, $logger);
        } elseif (preg_match('/OmniWeb/', $agent)) {
            $browser = new Omniweb($agent, $logger);
        } elseif (preg_match('/Windows Phone Search/', $agent)) {
            $browser = new WindowsPhoneSearch($agent, $logger);
        } elseif (preg_match('/^windows/i', $agent)) {
            $browser = new FakeBrowser($agent, $logger);
        } elseif (preg_match('/nokia/i', $agent)) {
            $browser = new NokiaBrowser($agent, $logger);
        } elseif (preg_match('/coast/i', $agent)) {
            $browser = new OperaCoast($agent, $logger);
        } elseif (preg_match('/(twitter for i)/i', $agent)) {
            $browser = new TwitterApp($agent, $logger);
        } elseif (preg_match('/GSA/i', $agent)) {
            $browser = new GoogleApp($agent, $logger);
        } elseif (preg_match('/QtCarBrowser/', $agent)) {
            $browser = new ModelsBrowser($agent, $logger);
        } elseif (preg_match('/Qt/', $agent)) {
            $browser = new Qt($agent, $logger);
        } elseif (preg_match('/Instagram/', $agent)) {
            $browser = new InstagramApp($agent, $logger);
        } elseif (preg_match('/WebClip/', $agent)) {
            $browser = new WebClip($agent, $logger);
        } elseif (preg_match('/Mercury/', $agent)) {
            $browser = new Mercury($agent, $logger);
        } elseif (preg_match('/AppStore/', $agent)) {
            $browser = new AppleAppStoreApp($agent, $logger);
        } elseif (preg_match('/Webglance/', $agent)) {
            $browser = new WebGlance($agent, $logger);
        } elseif (preg_match('/YHOO\_Search\_App/', $agent)) {
            $browser = new YahooMobileApp($agent, $logger);
        } elseif (preg_match('/NewsBlur Feed Fetcher/', $agent)) {
            $browser = new NewsBlurFeedFetcher($agent, $logger);
        } elseif (preg_match('/AppleCoreMedia/', $agent)) {
            $browser = new AppleCoreMedia($agent, $logger);
        } elseif (preg_match('/dataaccessd/', $agent)) {
            $browser = new IosDataaccessd($agent, $logger);
        } elseif (preg_match('/MailChimp/', $agent)) {
            $browser = new MailChimp($agent, $logger);
        } elseif (preg_match('/^Mail/', $agent)) {
            $browser = new AppleMail($agent, $logger);
        } elseif (preg_match('/^Mozilla\/5\.0.*\(.*(CPU iPhone OS|CPU OS) \d+(_|\.)\d+.* like Mac OS X.*\) AppleWebKit.* \(KHTML, like Gecko\)$/', $agent)) {
            $browser = new AppleMail($agent, $logger);
        } elseif (preg_match('/^Mozilla\/5\.0 \(Macintosh; Intel Mac OS X.*\) AppleWebKit.* \(KHTML, like Gecko\)$/', $agent)) {
            $browser = new AppleMail($agent, $logger);
        } elseif (preg_match('/^Mozilla\/5\.0 \(Windows.*\) AppleWebKit.* \(KHTML, like Gecko\)$/', $agent)) {
            $browser = new AppleMail($agent, $logger);
        } elseif (preg_match('/msnbot\-media/i', $agent)) {
            $browser = new MsnBotMedia($agent, $logger);
        } elseif (preg_match('/(backberry|bb10)/i', $agent)) {
            $browser = new Blackberry($agent, $logger);
        } elseif (preg_match('/WeTab\-Browser/', $agent)) {
            $browser = new WeTabBrowser($agent, $logger);
        } elseif (preg_match('/profiller/', $agent)) {
            $browser = new Profiller($agent, $logger);
        } elseif (preg_match('/(wkhtmltoimage|wkhtmltopdf)/i', $agent)) {
            $browser = new WkHtmltopdf($agent, $logger);
        } elseif (preg_match('/(wp\-iphone|wp\-android)/', $agent)) {
            $browser = new WordPressApp($agent, $logger);
        } elseif (preg_match('/OktaMobile/', $agent)) {
            $browser = new OktaMobileApp($agent, $logger);
        } elseif (preg_match('/kmail2/', $agent)) {
            $browser = new Kmail2($agent, $logger);
        } elseif (preg_match('/eb\-iphone/', $agent)) {
            $browser = new EbApp($agent, $logger);
        } elseif (preg_match('/ElmediaPlayer/', $agent)) {
            $browser = new ElmediaPlayer($agent, $logger);
        } elseif (preg_match('/Schoolwires/', $agent)) {
            $browser = new SchoolwiresApp($agent, $logger);
        } elseif (preg_match('/Dreamweaver/', $agent)) {
            $browser = new Dreamweaver($agent, $logger);
        } elseif (preg_match('/akregator/', $agent)) {
            $browser = new Akregator($agent, $logger);
        } elseif (preg_match('/Installatron/', $agent)) {
            $browser = new Installatron($agent, $logger);
        } elseif (preg_match('/Quora/', $agent)) {
            $browser = new QuoraApp($agent, $logger);
        } elseif (preg_match('/Rocky ChatWork Mobile/', $agent)) {
            $browser = new RockyChatWorkMobile($agent, $logger);
        } elseif (preg_match('/AdsBot\-Google\-Mobile/', $agent)) {
            $browser = new GoogleAdsbotMobile($agent, $logger);
        } elseif (preg_match('/Epiphany/', $agent)) {
            $browser = new Epiphany($agent, $logger);
        } elseif (preg_match('/rekonq/', $agent)) {
            $browser = new Rekonq($agent, $logger);
        } elseif (preg_match('/Skyfire/', $agent)) {
            $browser = new Skyfire($agent, $logger);
        } elseif (preg_match('/FlixsteriOS/', $agent)) {
            $browser = new FlixsterApp($agent, $logger);
        } elseif (preg_match('/(adbeat\_bot|adbeat\.com)/', $agent)) {
            $browser = new AdbeatBot($agent, $logger);
        } elseif (preg_match('/(SecondLife|Second Life)/', $agent)) {
            $browser = new SecondLiveClient($agent, $logger);
        } elseif (preg_match('/(Salesforce1|SalesforceTouchContainer)/', $agent)) {
            $browser = new SalesForceApp($agent, $logger);
        } elseif (preg_match('/(nagios\-plugins|check\_http)/', $agent)) {
            $browser = new Nagios($agent, $logger);
        } elseif (preg_match('/bingbot/i', $agent)) {
            $browser = new Bingbot($agent, $logger);
        } elseif (preg_match('/safari/i', $agent)) {
            $browser = new Safari($agent, $logger);
        } elseif (preg_match('/^Mozilla\/(4|5)\.0 \(Macintosh; .* Mac OS X .*\) AppleWebKit\/.* \(KHTML, like Gecko\) Version\/[\d\.]+$/i', $agent)) {
            $browser = new Safari($agent, $logger);
        } elseif (preg_match('/TWCAN\/SportsNet/', $agent)) {
            $browser = new TwcSportsNet($agent, $logger);
        } elseif (preg_match('/^Mozilla\/5\.0.*\((iPhone|iPad|iPod).*\).*AppleWebKit\/.*\(.*KHTML, like Gecko.*\).*Mobile.*/i', $agent)) {
            $browser = new MobileSafariUiWebView($agent, $logger);
        } elseif (preg_match('/PaleMoon/', $agent)) {
            $browser = new Palemoon($agent, $logger);
        } elseif (preg_match('/waterfox/i', $agent)) {
            $browser = new WaterFox($agent, $logger);
        } elseif (preg_match('/QupZilla/', $agent)) {
            $browser = new QupZilla($agent, $logger);
        } elseif (preg_match('/Thunderbird/', $agent)) {
            $browser = new Thunderbird($agent, $logger);
        } elseif (preg_match('/kontact/', $agent)) {
            $browser = new Kontact($agent, $logger);
        } elseif (preg_match('/(Fennec)/', $agent)) {
            $browser = new Fennec($agent, $logger);
        } elseif (preg_match('/(myibrow)/', $agent)) {
            $browser = new MyInternetBrowser($agent, $logger);
        } elseif (preg_match('/(Daumoa)/', $agent)) {
            $browser = new Daumoa($agent, $logger);
        } elseif (preg_match('/(PaleMoon)/', $agent)) {
            $browser = new Palemoon($agent, $logger);
        } elseif (preg_match('/GomezAgent/', $agent)) {
            $browser = new GomezSiteMonitor($agent, $logger);
        } elseif (preg_match('/Iceweasel/', $agent)) {
            $browser = new Iceweasel($agent, $logger);
        } elseif (preg_match('/SurveyBot/', $agent)) {
            $browser = new SurveyBot($agent, $logger);
        } elseif (preg_match('/aggregator\:Spinn3r/', $agent)) {
            $browser = new Spinn3rRssAggregator($agent, $logger);
        } elseif (preg_match('/TweetmemeBot/', $agent)) {
            $browser = new TweetmemeBot($agent, $logger);
        } elseif (preg_match('/Butterfly/', $agent)) {
            $browser = new ButterflyRobot($agent, $logger);
        } elseif (preg_match('/James BOT/', $agent)) {
            $browser = new JamesBot($agent, $logger);
        } elseif (preg_match('/firefox/i', $agent)
            && !preg_match('/gecko/i', $agent)
            && preg_match('/anonymized/i', $agent)
        ) {
            $browser = new Firefox($agent, $logger);
        } elseif (preg_match('/firefox/i', $agent) && !preg_match('/gecko/i', $agent)) {
            $browser = new FakeBrowser($agent, $logger);
        } elseif (preg_match('/(firefox|minefield|shiretoko|bonecho|namoroka|fxios)/i', $agent)) {
            $browser = new Firefox($agent, $logger);
        } elseif (preg_match('/(SMTBot)/', $agent)) {
            $browser = new SmtBot($agent, $logger);
        } elseif (preg_match('/(gvfs)/', $agent)) {
            $browser = new Gvfs($agent, $logger);
        } elseif (preg_match('/(luakit)/', $agent)) {
            $browser = new Luakit($agent, $logger);
        } elseif (preg_match('/(playstation 3)/i', $agent)) {
            $browser = new PlaystationBrowser($agent, $logger);
        } elseif (preg_match('/sistrix/i', $agent)) {
            $browser = new Sistrix($agent, $logger);
        } elseif (preg_match('/(ezooms)/i', $agent)) {
            $browser = new Ezooms($agent, $logger);
        } elseif (preg_match('/grapefx/i', $agent)) {
            $browser = new GrapeFx($agent, $logger);
        } elseif (preg_match('/grapeshotcrawler/i', $agent)) {
            $browser = new GrapeshotCrawler($agent, $logger);
        } elseif (preg_match('/(mail\.ru)/i', $agent)) {
            $browser = new MailRu($agent, $logger);
        } elseif (preg_match('/(kazehakase)/i', $agent)) {
            $browser = new Kazehakase($agent, $logger);
        } elseif (preg_match('/(proximic)/i', $agent)) {
            $browser = new Proximic($agent, $logger);
        } elseif (preg_match('/(polaris)/i', $agent)) {
            $browser = new Polaris($agent, $logger);
        } elseif (preg_match('/(another web mining tool|awmt)/i', $agent)) {
            $browser = new AnotherWebMiningTool($agent, $logger);
        } elseif (preg_match('/(wbsearchbot)/i', $agent)) {
            $browser = new WbSearchBot($agent, $logger);
        } elseif (preg_match('/(konqueror)/i', $agent)) {
            $browser = new Konqueror($agent, $logger);
        } elseif (preg_match('/(typo3\-linkvalidator)/i', $agent)) {
            $browser = new Typo3Linkvalidator($agent, $logger);
        } elseif (preg_match('/feeddlerrss/i', $agent)) {
            $browser = new FeeddlerRssReader($agent, $logger);
        } elseif (preg_match('/(ios|iphone|ipad|ipod)/i', $agent)) {
            $browser = new Safari($agent, $logger);
        } elseif (preg_match('/(slurp)/i', $agent)) {
            $browser = new YahooSlurp($agent, $logger);
        } elseif (preg_match('/(paperlibot)/i', $agent)) {
            $browser = new PaperLiBot($agent, $logger);
        } elseif (preg_match('/(spbot)/i', $agent)) {
            $browser = new Seoprofiler($agent, $logger);
        } elseif (preg_match('/(dotbot)/i', $agent)) {
            $browser = new DotBot($agent, $logger);
        } elseif (preg_match('/(google\-structureddatatestingtool)/i', $agent)) {
            $browser = new GoogleStructuredDataTestingTool($agent, $logger);
        } elseif (preg_match('/webmastercoffee/i', $agent)) {
            $browser = new WebmasterCoffee($agent, $logger);
        } elseif (preg_match('/ahrefs/i', $agent)) {
            $browser = new AhrefsBot($agent, $logger);
        } elseif (preg_match('/apercite/i', $agent)) {
            $browser = new Apercite($agent, $logger);
        } elseif (preg_match('/woobot/', $agent)) {
            $browser = new WooRank($agent, $logger);
        } elseif (preg_match('/Blekkobot/', $agent)) {
            $browser = new BlekkoBot($agent, $logger);
        } elseif (preg_match('/PagesInventory/', $agent)) {
            $browser = new PagesInventoryBot($agent, $logger);
        } elseif (preg_match('/Slackbot\-LinkExpanding/', $agent)) {
            $browser = new SlackbotLinkExpanding($agent, $logger);
        } elseif (preg_match('/Slackbot/', $agent)) {
            $browser = new Slackbot($agent, $logger);
        } elseif (preg_match('/SEOkicks\-Robot/', $agent)) {
            $browser = new Seokicks($agent, $logger);
        } elseif (preg_match('/Exabot/', $agent)) {
            $browser = new Exabot($agent, $logger);
        } elseif (preg_match('/DomainSCAN/', $agent)) {
            $browser = new DomainScanServerMonitoring($agent, $logger);
        } elseif (preg_match('/JobRoboter/', $agent)) {
            $browser = new JobRoboter($agent, $logger);
        } elseif (preg_match('/AcoonBot/', $agent)) {
            $browser = new AcoonBot($agent, $logger);
        } elseif (preg_match('/woriobot/', $agent)) {
            $browser = new Woriobot($agent, $logger);
        } elseif (preg_match('/MonoBot/', $agent)) {
            $browser = new MonoBot($agent, $logger);
        } elseif (preg_match('/DomainSigmaCrawler/', $agent)) {
            $browser = new DomainSigmaCrawler($agent, $logger);
        } elseif (preg_match('/bnf\.fr\_bot/', $agent)) {
            $browser = new BnfFrBot($agent, $logger);
        } elseif (preg_match('/CrawlRobot/', $agent)) {
            $browser = new CrawlRobot($agent, $logger);
        } elseif (preg_match('/AddThis\.com robot/', $agent)) {
            $browser = new AddThisRobot($agent, $logger);
        } elseif (preg_match('/obot/i', $agent)) {
            $browser = new Obot($agent, $logger);
        } elseif (preg_match('/ZumBot/', $agent)) {
            $browser = new ZumBot($agent, $logger);
        } elseif (preg_match('/(umbot)/i', $agent)) {
            $browser = new UmBot($agent, $logger);
        } elseif (preg_match('/(picmole)/i', $agent)) {
            $browser = new PicmoleBot($agent, $logger);
        } elseif (preg_match('/(zollard)/i', $agent)) {
            $browser = new ZollardWorm($agent, $logger);
        } elseif (preg_match('/(fhscan core)/i', $agent)) {
            $browser = new FhscanCore($agent, $logger);
        } elseif (preg_match('/adidxbot/i', $agent)) {
            $browser = new Adidxbot($agent, $logger);
        } elseif (preg_match('/nbot/i', $agent)) {
            $browser = new Nbot($agent, $logger);
        } elseif (preg_match('/(loadtimebot)/i', $agent)) {
            $browser = new LoadTimeBot($agent, $logger);
        } elseif (preg_match('/(scrubby)/i', $agent)) {
            $browser = new Scrubby($agent, $logger);
        } elseif (preg_match('/(squzer)/i', $agent)) {
            $browser = new Squzer($agent, $logger);
        } elseif (preg_match('/PiplBot/', $agent)) {
            $browser = new PiplBot($agent, $logger);
        } elseif (preg_match('/EveryoneSocialBot/', $agent)) {
            $browser = new EveryoneSocialBot($agent, $logger);
        } elseif (preg_match('/AOLbot/', $agent)) {
            $browser = new AolBot($agent, $logger);
        } elseif (preg_match('/GLBot/', $agent)) {
            $browser = new GlBot($agent, $logger);
        } elseif (preg_match('/(lbot)/i', $agent)) {
            $browser = new Lbot($agent, $logger);
        } elseif (preg_match('/(blexbot)/i', $agent)) {
            $browser = new BlexBot($agent, $logger);
        } elseif (preg_match('/(easouspider)/i', $agent)) {
            $browser = new EasouSpider($agent, $logger);
        } elseif (preg_match('/(socialradarbot)/i', $agent)) {
            $browser = new Socialradarbot($agent, $logger);
        } elseif (preg_match('/(synapse)/i', $agent)) {
            $browser = new ApacheSynapse($agent, $logger);
        } elseif (preg_match('/(linkdexbot)/i', $agent)) {
            $browser = new LinkdexBot($agent, $logger);
        } elseif (preg_match('/(coccoc)/i', $agent)) {
            $browser = new CocCocBot($agent, $logger);
        } elseif (preg_match('/(siteexplorer)/i', $agent)) {
            $browser = new SiteExplorer($agent, $logger);
        } elseif (preg_match('/(semrushbot)/i', $agent)) {
            $browser = new SemrushBot($agent, $logger);
        } elseif (preg_match('/(istellabot)/i', $agent)) {
            $browser = new IstellaBot($agent, $logger);
        } elseif (preg_match('/(meanpathbot)/i', $agent)) {
            $browser = new MeanpathBot($agent, $logger);
        } elseif (preg_match('/(XML Sitemaps Generator)/', $agent)) {
            $browser = new XmlSitemapsGenerator($agent, $logger);
        } elseif (preg_match('/SeznamBot/', $agent)) {
            $browser = new SeznamBot($agent, $logger);
        } elseif (preg_match('/URLAppendBot/', $agent)) {
            $browser = new UrlAppendBot($agent, $logger);
        } elseif (preg_match('/NetSeer crawler/', $agent)) {
            $browser = new NetseerCrawler($agent, $logger);
        } elseif (preg_match('/SeznamBot/', $agent)) {
            $browser = new SeznamBot($agent, $logger);
        } elseif (preg_match('/Add Catalog/', $agent)) {
            $browser = new AddCatalog($agent, $logger);
        } elseif (preg_match('/Moreover/', $agent)) {
            $browser = new Moreover($agent, $logger);
        } elseif (preg_match('/LinkpadBot/', $agent)) {
            $browser = new LinkpadBot($agent, $logger);
        } elseif (preg_match('/Lipperhey SEO Service/', $agent)) {
            $browser = new LipperheySeoService($agent, $logger);
        } elseif (preg_match('/Blog Search/', $agent)) {
            $browser = new BlogSearch($agent, $logger);
        } elseif (preg_match('/Qualidator\.com Bot/', $agent)) {
            $browser = new QualidatorBot($agent, $logger);
        } elseif (preg_match('/fr\-crawler/', $agent)) {
            $browser = new FrCrawler($agent, $logger);
        } elseif (preg_match('/ca\-crawler/', $agent)) {
            $browser = new CaCrawler($agent, $logger);
        } elseif (preg_match('/Website Thumbnail Generator/', $agent)) {
            $browser = new WebsiteThumbnailGenerator($agent, $logger);
        } elseif (preg_match('/WebThumb/', $agent)) {
            $browser = new WebThumb($agent, $logger);
        } elseif (preg_match('/KomodiaBot/', $agent)) {
            $browser = new KomodiaBot($agent, $logger);
        } elseif (preg_match('/GroupHigh/', $agent)) {
            $browser = new GroupHighBot($agent, $logger);
        } elseif (preg_match('/theoldreader/', $agent)) {
            $browser = new TheOldReader($agent, $logger);
        } elseif (preg_match('/Google\-Site\-Verification/', $agent)) {
            $browser = new GoogleSiteVerification($agent, $logger);
        } elseif (preg_match('/Prlog/', $agent)) {
            $browser = new Prlog($agent, $logger);
        } elseif (preg_match('/CMS Crawler/', $agent)) {
            $browser = new CmsCrawler($agent, $logger);
        } elseif (preg_match('/pmoz\.info ODP link checker/', $agent)) {
            $browser = new PmozinfoOdpLinkChecker($agent, $logger);
        } elseif (preg_match('/Twingly Recon/', $agent)) {
            $browser = new TwinglyRecon($agent, $logger);
        } elseif (preg_match('/Embedly/', $agent)) {
            $browser = new Embedly($agent, $logger);
        } elseif (preg_match('/Alexabot/', $agent)) {
            $browser = new Alexabot($agent, $logger);
        } elseif (preg_match('/MJ12bot/', $agent)) {
            $browser = new Mj12bot($agent, $logger);
        } elseif (preg_match('/HTTrack/', $agent)) {
            $browser = new Httrack($agent, $logger);
        } elseif (preg_match('/UnisterBot/', $agent)) {
            $browser = new Unisterbot($agent, $logger);
        } elseif (preg_match('/CareerBot/', $agent)) {
            $browser = new CareerBot($agent, $logger);
        } elseif (preg_match('/80legs/i', $agent)) {
            $browser = new Bot80Legs($agent, $logger);
        } elseif (preg_match('/wada\.vn/i', $agent)) {
            $browser = new WadavnSearchBot($agent, $logger);
        } elseif (preg_match('/AdobeAIR/', $agent)) {
            $browser = new AdobeAIR($agent, $logger);
        } elseif (preg_match('/(NX|WiiU|Nintendo 3DS)/', $agent)) {
            $browser = new NetFrontNx($agent, $logger);
        } elseif (preg_match('/(netfront|playstation 4)/i', $agent)) {
            $browser = new NetFront($agent, $logger);
        } elseif (preg_match('/XoviBot/', $agent)) {
            $browser = new XoviBot($agent, $logger);
        } elseif (preg_match('/007ac9 Crawler/', $agent)) {
            $browser = new Crawler007AC9($agent, $logger);
        } elseif (preg_match('/200PleaseBot/', $agent)) {
            $browser = new Please200Bot($agent, $logger);
        } elseif (preg_match('/Abonti/', $agent)) {
            $browser = new AbontiBot($agent, $logger);
        } elseif (preg_match('/publiclibraryarchive/', $agent)) {
            $browser = new PublicLibraryArchive($agent, $logger);
        } elseif (preg_match('/PAD\-bot/', $agent)) {
            $browser = new PadBot($agent, $logger);
        } elseif (preg_match('/SoftListBot/', $agent)) {
            $browser = new SoftListBot($agent, $logger);
        } elseif (preg_match('/sReleaseBot/', $agent)) {
            $browser = new SreleaseBot($agent, $logger);
        } elseif (preg_match('/Vagabondo/', $agent)) {
            $browser = new Vagabondo($agent, $logger);
        } elseif (preg_match('/special\_archiver/', $agent)) {
            $browser = new InternetArchiveSpecialArchiver($agent, $logger);
        } elseif (preg_match('/Optimizer/', $agent)) {
            $browser = new OptimizerBot($agent, $logger);
        } elseif (preg_match('/Sophora Linkchecker/', $agent)) {
            $browser = new SophoraLinkchecker($agent, $logger);
        } elseif (preg_match('/SEOdiver/', $agent)) {
            $browser = new SeoDiver($agent, $logger);
        } elseif (preg_match('/itsscan/', $agent)) {
            $browser = new ItsScan($agent, $logger);
        } elseif (preg_match('/Google Desktop/', $agent)) {
            $browser = new GoogleDesktop($agent, $logger);
        } elseif (preg_match('/Lotus\-Notes/', $agent)) {
            $browser = new LotusNotes($agent, $logger);
        } elseif (preg_match('/AskPeterBot/', $agent)) {
            $browser = new AskPeterBot($agent, $logger);
        } elseif (preg_match('/discoverybot/', $agent)) {
            $browser = new DiscoveryBot($agent, $logger);
        } elseif (preg_match('/YandexBot/', $agent)) {
            $browser = new YandexBot($agent, $logger);
        } elseif (preg_match('/MOSBookmarks/', $agent) && preg_match('/Link Checker/', $agent)) {
            $browser = new MosBookmarksLinkChecker($agent, $logger);
        } elseif (preg_match('/MOSBookmarks/', $agent)) {
            $browser = new MosBookmarks($agent, $logger);
        } elseif (preg_match('/WebMasterAid/', $agent)) {
            $browser = new WebMasterAid($agent, $logger);
        } elseif (preg_match('/AboutUsBot Johnny5/', $agent)) {
            $browser = new AboutUsBotJohnny5($agent, $logger);
        } elseif (preg_match('/AboutUsBot/', $agent)) {
            $browser = new AboutUsBot($agent, $logger);
        } elseif (preg_match('/semantic\-visions\.com crawler/', $agent)) {
            $browser = new SemanticVisionsCrawler($agent, $logger);
        } elseif (preg_match('/waybackarchive\.org/', $agent)) {
            $browser = new WaybackArchive($agent, $logger);
        } elseif (preg_match('/OpenVAS/', $agent)) {
            $browser = new OpenVulnerabilityAssessmentSystem($agent, $logger);
        } elseif (preg_match('/Seznam screenshot\-generator/', $agent)) {
            $browser = new SeznamScreenshotGenerator($agent, $logger);
        } elseif (preg_match('/MixrankBot/', $agent)) {
            $browser = new MixrankBot($agent, $logger);
        } elseif (preg_match('/InfegyAtlas/', $agent)) {
            $browser = new InfegyAtlasBot($agent, $logger);
        } elseif (preg_match('/MojeekBot/', $agent)) {
            $browser = new MojeekBot($agent, $logger);
        } elseif (preg_match('/memorybot/i', $agent)) {
            $browser = new MemoryBot($agent, $logger);
        } elseif (preg_match('/DomainAppender/', $agent)) {
            $browser = new DomainAppenderBot($agent, $logger);
        } elseif (preg_match('/GIDBot/', $agent)) {
            $browser = new GidBot($agent, $logger);
        } elseif (preg_match('/DBot/', $agent)) {
            $browser = new Dbot($agent, $logger);
        } elseif (preg_match('/PWBot/', $agent)) {
            $browser = new PwBot($agent, $logger);
        } elseif (preg_match('/\+5Bot/', $agent)) {
            $browser = new Plus5Bot($agent, $logger);
        } elseif (preg_match('/WASALive\-Bot/', $agent)) {
            $browser = new WasaLiveBot($agent, $logger);
        } elseif (preg_match('/OpenHoseBot/', $agent)) {
            $browser = new OpenHoseBot($agent, $logger);
        } elseif (preg_match('/URLfilterDB\-crawler/', $agent)) {
            $browser = new UrlfilterDbCrawler($agent, $logger);
        } elseif (preg_match('/metager2\-verification\-bot/', $agent)) {
            $browser = new Metager2VerificationBot($agent, $logger);
        } elseif (preg_match('/Powermarks/', $agent)) {
            $browser = new Powermarks($agent, $logger);
        } elseif (preg_match('/CloudFlare\-AlwaysOnline/', $agent)) {
            $browser = new CloudFlareAlwaysOnline($agent, $logger);
        } elseif (preg_match('/Phantom\.js bot/', $agent)) {
            $browser = new PhantomJsBot($agent, $logger);
        } elseif (preg_match('/Phantom/', $agent)) {
            $browser = new PhantomBrowser($agent, $logger);
        } elseif (preg_match('/Shrook/', $agent)) {
            $browser = new Shrook($agent, $logger);
        } elseif (preg_match('/netEstate NE Crawler/', $agent)) {
            $browser = new NetEstateCrawler($agent, $logger);
        } elseif (preg_match('/garlikcrawler/i', $agent)) {
            $browser = new GarlikCrawler($agent, $logger);
        } elseif (preg_match('/metageneratorcrawler/i', $agent)) {
            $browser = new MetaGeneratorCrawler($agent, $logger);
        } elseif (preg_match('/ScreenerBot/', $agent)) {
            $browser = new ScreenerBot($agent, $logger);
        } elseif (preg_match('/WebTarantula\.com Crawler/', $agent)) {
            $browser = new WebTarantula($agent, $logger);
        } elseif (preg_match('/BacklinkCrawler/', $agent)) {
            $browser = new BacklinkCrawler($agent, $logger);
        } elseif (preg_match('/LinksCrawler/', $agent)) {
            $browser = new LinksCrawler($agent, $logger);
        } elseif (preg_match('/(ssearch\_bot|sSearch Crawler)/', $agent)) {
            $browser = new SsearchCrawler($agent, $logger);
        } elseif (preg_match('/HRCrawler/', $agent)) {
            $browser = new HrCrawler($agent, $logger);
        } elseif (preg_match('/ICC\-Crawler/', $agent)) {
            $browser = new IccCrawler($agent, $logger);
        } elseif (preg_match('/Arachnida Web Crawler/', $agent)) {
            $browser = new ArachnidaWebCrawler($agent, $logger);
        } elseif (preg_match('/Finderlein Research Crawler/', $agent)) {
            $browser = new FinderleinResearchCrawler($agent, $logger);
        } elseif (preg_match('/TestCrawler/', $agent)) {
            $browser = new TestCrawler($agent, $logger);
        } elseif (preg_match('/Crawler/', $agent)) {
            $browser = new Crawler($agent, $logger);
        } elseif (preg_match('/MetaJobBot/', $agent)) {
            $browser = new MetaJobBot($agent, $logger);
        } elseif (preg_match('/jig browser web/', $agent)) {
            $browser = new JigBrowserWeb($agent, $logger);
        } elseif (preg_match('/T\-H\-U\-N\-D\-E\-R\-S\-T\-O\-N\-E/', $agent)) {
            $browser = new TexisWebscript($agent, $logger);
        } elseif (preg_match('/focuseekbot/', $agent)) {
            $browser = new Focuseekbot($agent, $logger);
        } elseif (preg_match('/vBSEO/', $agent)) {
            $browser = new VbulletinSeoBot($agent, $logger);
        } elseif (preg_match('/kgbody/', $agent)) {
            $browser = new Kgbody($agent, $logger);
        } elseif (preg_match('/JobdiggerSpider/', $agent)) {
            $browser = new JobdiggerSpider($agent, $logger);
        } elseif (preg_match('/imrbot/', $agent)) {
            $browser = new MignifyBot($agent, $logger);
        } elseif (preg_match('/kulturarw3/', $agent)) {
            $browser = new Kulturarw3($agent, $logger);
        } elseif (preg_match('/LucidWorks/', $agent)) {
            $browser = new LucidworksBot($agent, $logger);
        } elseif (preg_match('/MerchantCentricBot/', $agent)) {
            $browser = new MerchantCentricBot($agent, $logger);
        } elseif (preg_match('/360SE/', $agent)) {
            $browser = new SecureBrowser360($agent, $logger);
        } elseif (preg_match('/Nett\.io bot/', $agent)) {
            $browser = new NettioBot($agent, $logger);
        } elseif (preg_match('/SemanticBot/', $agent)) {
            $browser = new SemanticBot($agent, $logger);
        } elseif (preg_match('/TweetedTimes Bot/', $agent)) {
            $browser = new TweetedTimesBot($agent, $logger);
        } elseif (preg_match('/vkShare/', $agent)) {
            $browser = new VkShare($agent, $logger);
        } elseif (preg_match('/Yahoo Ad monitoring/', $agent)) {
            $browser = new YahooAdMonitoring($agent, $logger);
        } elseif (preg_match('/YioopBot/', $agent)) {
            $browser = new YioopBot($agent, $logger);
        } elseif (preg_match('/zitebot/', $agent)) {
            $browser = new Zitebot($agent, $logger);
        } elseif (preg_match('/Espial/', $agent)) {
            $browser = new EspialTvBrowser($agent, $logger);
        } elseif (preg_match('/SiteCon/', $agent)) {
            $browser = new SiteCon($agent, $logger);
        } elseif (preg_match('/iBooks Author/', $agent)) {
            $browser = new IbooksAuthor($agent, $logger);
        } elseif (preg_match('/iWeb/', $agent)) {
            $browser = new Iweb($agent, $logger);
        } elseif (preg_match('/NewsFire/', $agent)) {
            $browser = new NewsFire($agent, $logger);
        } elseif (preg_match('/RMSnapKit/', $agent)) {
            $browser = new RmSnapKit($agent, $logger);
        } elseif (preg_match('/Sandvox/', $agent)) {
            $browser = new Sandvox($agent, $logger);
        } elseif (preg_match('/TubeTV/', $agent)) {
            $browser = new TubeTv($agent, $logger);
        } elseif (preg_match('/Elluminate Live/', $agent)) {
            $browser = new ElluminateLive($agent, $logger);
        } elseif (preg_match('/Element Browser/', $agent)) {
            $browser = new ElementBrowser($agent, $logger);
        } elseif (preg_match('/K\-Meleon/', $agent)) {
            $browser = new Kmeleon($agent, $logger);
        } elseif (preg_match('/Esribot/', $agent)) {
            $browser = new Esribot($agent, $logger);
        } elseif (preg_match('/QuickLook/', $agent)) {
            $browser = new QuickLook($agent, $logger);
        } elseif (preg_match('/dillo/i', $agent)) {
            $browser = new Dillo($agent, $logger);
        } elseif (preg_match('/Digg/', $agent)) {
            $browser = new DiggBot($agent, $logger);
        } elseif (preg_match('/Zetakey/', $agent)) {
            $browser = new ZetakeyBrowser($agent, $logger);
        } elseif (preg_match('/getprismatic\.com/', $agent)) {
            $browser = new PrismaticApp($agent, $logger);
        } elseif (preg_match('/(FOMA|SH05C)/', $agent)) {
            $browser = new Sharp($agent, $logger);
        } elseif (preg_match('/OpenWebKitSharp/', $agent)) {
            $browser = new OpenWebkitSharp($agent, $logger);
        } elseif (preg_match('/AjaxSnapBot/', $agent)) {
            $browser = new AjaxSnapBot($agent, $logger);
        } elseif (preg_match('/Owler/', $agent)) {
            $browser = new OwlerBot($agent, $logger);
        } elseif (preg_match('/Yahoo Link Preview/', $agent)) {
            $browser = new YahooLinkPreview($agent, $logger);
        } elseif (preg_match('/pub\-crawler/', $agent)) {
            $browser = new PubCrawler($agent, $logger);
        } elseif (preg_match('/RevIP\.info site analyzer/', $agent)) {
            $browser = new RevIpSnfoSiteAnalyzer($agent, $logger);
        } elseif (preg_match('/Kraken/', $agent)) {
            $browser = new Kraken($agent, $logger);
        } elseif (preg_match('/Qwantify/', $agent)) {
            $browser = new Qwantify($agent, $logger);
        } elseif (preg_match('/SetLinks bot/', $agent)) {
            $browser = new SetLinksCrawler($agent, $logger);
        } elseif (preg_match('/MegaIndex\.ru/', $agent)) {
            $browser = new MegaIndexBot($agent, $logger);
        } elseif (preg_match('/Cliqzbot/', $agent)) {
            $browser = new Cliqzbot($agent, $logger);
        } elseif (preg_match('/DAWINCI ANTIPLAG SPIDER/', $agent)) {
            $browser = new DawinciAntiplagSpider($agent, $logger);
        } elseif (preg_match('/AdvBot/', $agent)) {
            $browser = new AdvBot($agent, $logger);
        } elseif (preg_match('/DuckDuckGo\-Favicons\-Bot/', $agent)) {
            $browser = new DuckDuckFaviconsBot($agent, $logger);
        } elseif (preg_match('/ZyBorg/', $agent)) {
            $browser = new WiseNutSearchEngineCrawler($agent, $logger);
        } elseif (preg_match('/HyperCrawl/', $agent)) {
            $browser = new HyperCrawl($agent, $logger);
        } elseif (preg_match('/ARCHIVE\.ORG\.UA crawler/', $agent)) {
            $browser = new ArchiveOrgBot($agent, $logger);
        } elseif (preg_match('/worldwebheritage/', $agent)) {
            $browser = new WorldwebheritageBot($agent, $logger);
        } elseif (preg_match('/Netscape/', $agent)) {
            $browser = new Netscape($agent, $logger);
        } elseif (preg_match('/^Mozilla\/(\d)/', $agent, $matches)) {
            if (isset($matches[1]) && $matches[1] < 5) {
                $browser = new Netscape($agent, $logger);
            } else {
                $browser = new Mozilla($agent, $logger);
            }
        } elseif (preg_match('/^Dalvik\/\d/', $agent)) {
            $browser = new Dalvik($agent, $logger);
        } elseif (preg_match('/niki\-bot/', $agent)) {
            $browser = new NikiBot($agent, $logger);
        } elseif (preg_match('/ContextAd Bot/', $agent)) {
            $browser = new ContextadBot($agent, $logger);
        } elseif (preg_match('/integrity/', $agent)) {
            $browser = new Integrity($agent, $logger);
        } elseif (preg_match('/masscan/', $agent)) {
            $browser = new DownloadAccelerator($agent, $logger);
        } elseif (preg_match('/ZmEu/', $agent)) {
            $browser = new ZmEu($agent, $logger);
        } elseif (preg_match('/sogou web spider/i', $agent)) {
            $browser = new SogouWebSpider($agent, $logger);
        } elseif (preg_match('/(OpenWave|UP\.Browser|UP\/)/', $agent)) {
            $browser = new Openwave($agent, $logger);
        } elseif (preg_match('/(Teleca|Obigo|MIC\/|AU\-MIC)/', $agent)) {
            $browser = new TelecaObigo($agent, $logger);
        } elseif (preg_match('/DavClnt/', $agent)) {
            $browser = new MicrosoftWebDav($agent, $logger);
        } elseif (preg_match('/XING\-contenttabreceiver/', $agent)) {
            $browser = new XingContenttabreceiver($agent, $logger);
        } elseif (preg_match('/Slingstone/', $agent)) {
            $browser = new YahooSlingstone($agent, $logger);
        } elseif (preg_match('/BOT for JCE/', $agent)) {
            $browser = new BotForJce($agent, $logger);
        } elseif (preg_match('/Validator\.nu\/LV/', $agent)) {
            $browser = new W3cValidatorNuLv($agent, $logger);
        } elseif (preg_match('/Ruby/', $agent)) {
            $browser = new Ruby($agent, $logger);
        } elseif (preg_match('/securepoint cf/', $agent)) {
            $browser = new SecurepointContentFilter($agent, $logger);
        } elseif (preg_match('/sogou\-spider/i', $agent)) {
            $browser = new SogouSpider($agent, $logger);
        } elseif (preg_match('/rankflex/i', $agent)) {
            $browser = new RankFlex($agent, $logger);
        } elseif (preg_match('/domnutch/i', $agent)) {
            $browser = new Domnutch($agent, $logger);
        } elseif (preg_match('/discovered/i', $agent)) {
            $browser = new DiscoverEd($agent, $logger);
        } elseif (preg_match('/boardreader favicon fetcher/i', $agent)) {
            $browser = new BoardReaderFaviconFetcher($agent, $logger);
        } elseif (preg_match('/checksite verification agent/i', $agent)) {
            $browser = new CheckSiteVerificationAgent($agent, $logger);
        } elseif (preg_match('/experibot/i', $agent)) {
            $browser = new Experibot($agent, $logger);
        } elseif (preg_match('/feedblitz/i', $agent)) {
            $browser = new FeedBlitz($agent, $logger);
        } elseif (preg_match('/rss2html/i', $agent)) {
            $browser = new Rss2Html($agent, $logger);
        } elseif (preg_match('/feedlyapp/i', $agent)) {
            $browser = new FeedlyApp($agent, $logger);
        } elseif (preg_match('/genderanalyzer/i', $agent)) {
            $browser = new Genderanalyzer($agent, $logger);
        } elseif (preg_match('/gooblog/i', $agent)) {
            $browser = new GooBlog($agent, $logger);
        } elseif (preg_match('/tumblr/i', $agent)) {
            $browser = new TumblrApp($agent, $logger);
        } elseif (preg_match('/w3c\_i18n\-checker/i', $agent)) {
            $browser = new W3cI18nChecker($agent, $logger);
        } elseif (preg_match('/w3c\_unicorn/i', $agent)) {
            $browser = new W3cUnicorn($agent, $logger);
        } elseif (preg_match('/alltop/i', $agent)) {
            $browser = new AlltopApp($agent, $logger);
        } elseif (preg_match('/internetseer/i', $agent)) {
            $browser = new InternetSeer($agent, $logger);
        } elseif (preg_match('/pinterest/i', $agent)) {
            $browser = new PinterestApp($agent, $logger);
        } elseif (preg_match('/ADmantX Platform Semantic Analyzer/', $agent)) {
            $browser = new AdmantxPlatformSemanticAnalyzer($agent, $logger);
        } elseif (preg_match('/UniversalFeedParser/', $agent)) {
            $browser = new UniversalFeedParser($agent, $logger);
        } elseif (preg_match('/(binlar|larbin)/i', $agent)) {
            $browser = new Larbin($agent, $logger);
        } elseif (preg_match('/unityplayer/i', $agent)) {
            $browser = new UnityWebPlayer($agent, $logger);
        } elseif (preg_match('/WeSEE\:Search/', $agent)) {
            $browser = new WeseeSearch($agent, $logger);
        } elseif (preg_match('/WeSEE\:Ads/', $agent)) {
            $browser = new WeseeAds($agent, $logger);
        } elseif (preg_match('/A6\-Indexer/', $agent)) {
            $browser = new A6Indexer($agent, $logger);
        } elseif (preg_match('/NerdyBot/', $agent)) {
            $browser = new NerdyBot($agent, $logger);
        } elseif (preg_match('/Peeplo Screenshot Bot/', $agent)) {
            $browser = new PeeploScreenshotBot($agent, $logger);
        } elseif (preg_match('/CCBot/', $agent)) {
            $browser = new CcBot($agent, $logger);
        } elseif (preg_match('/visionutils/', $agent)) {
            $browser = new VisionUtils($agent, $logger);
        } elseif (preg_match('/Feedly/', $agent)) {
            $browser = new Feedly($agent, $logger);
        } elseif (preg_match('/Photon/', $agent)) {
            $browser = new Photon($agent, $logger);
        } elseif (preg_match('/WDG\_Validator/', $agent)) {
            $browser = new WdgHtmlValidator($agent, $logger);
        } elseif (preg_match('/Aboundex/', $agent)) {
            $browser = new Aboundexbot($agent, $logger);
        } elseif (preg_match('/YisouSpider/', $agent)) {
            $browser = new YisouSpider($agent, $logger);
        } elseif (preg_match('/hivaBot/', $agent)) {
            $browser = new HivaBot($agent, $logger);
        } elseif (preg_match('/Comodo Spider/', $agent)) {
            $browser = new ComodoSpider($agent, $logger);
        } elseif (preg_match('/OpenWebSpider/i', $agent)) {
            $browser = new OpenWebSpider($agent, $logger);
        } elseif (preg_match('/R6_CommentReader/i', $agent)) {
            $browser = new R6CommentReader($agent, $logger);
        } elseif (preg_match('/(psbot\-image|psbot\-page)/i', $agent)) {
            $browser = new Picsearchbot($agent, $logger);
        } elseif (preg_match('/Bloglovin/', $agent)) {
            $browser = new BloglovinBot($agent, $logger);
        } elseif (preg_match('/viralvideochart/i', $agent)) {
            $browser = new ViralvideochartBot($agent, $logger);
        } elseif (preg_match('/MetaHeadersBot/', $agent)) {
            $browser = new MetaHeadersBot($agent, $logger);
        } elseif (preg_match('/Zend\_Http\_Client/', $agent)) {
            $browser = new ZendHttpClient($agent, $logger);
        } elseif (preg_match('/wget/i', $agent)) {
            $browser = new Wget($agent, $logger);
        } elseif (preg_match('/Scrapy/', $agent)) {
            $browser = new ScrapyBot($agent, $logger);
        } elseif (preg_match('/Moozilla/', $agent)) {
            $browser = new Moozilla($agent, $logger);
        } elseif (preg_match('/AntBot/', $agent)) {
            $browser = new AntBot($agent, $logger);
        } elseif (preg_match('/Browsershots/', $agent)) {
            $browser = new Browsershots($agent, $logger);
        } elseif (preg_match('/revolt/', $agent)) {
            $browser = new BotRevolt($agent, $logger);
        } elseif (preg_match('/pdrlabs/i', $agent)) {
            $browser = new PdrlabsBot($agent, $logger);
        } elseif (preg_match('/Links/', $agent)) {
            $browser = new Links($agent, $logger);
        } elseif (preg_match('/WinHTTP/', $agent)) {
            $browser = new WinHttpRequest($agent, $logger);
        } elseif (preg_match('/Airmail/', $agent)) {
            $browser = new Airmail($agent, $logger);
        } elseif (preg_match('/Jasmine/', $agent)) {
            $browser = new Jasmine($agent, $logger);
        } elseif (preg_match('/samsung/i', $agent)) {
            $browser = new Samsung($agent, $logger);
        } elseif (preg_match('/SonyEricsson/', $agent)) {
            $browser = new SonyEricsson($agent, $logger);
        } elseif (preg_match('/WEB\.DE MailCheck/', $agent)) {
            $browser = new WebdeMailCheck($agent, $logger);
        } elseif (preg_match('/Screaming Frog SEO Spider/', $agent)) {
            $browser = new ScreamingFrogSeoSpider($agent, $logger);
        } elseif (preg_match('/AndroidDownloadManager/', $agent)) {
            $browser = new AndroidDownloadManager($agent, $logger);
        } elseif (preg_match('/Go ([\d\.]+) package http/', $agent)) {
            $browser = new GoHttpClient($agent, $logger);
        } elseif (preg_match('/Proxy Gear Pro/', $agent)) {
            $browser = new ProxyGearPro($agent, $logger);
        } elseif (preg_match('/WAP Browser\/MAUI/', $agent)) {
            $browser = new MauiWapBrowser($agent, $logger);
        } elseif (preg_match('/WordPress/', $agent)) {
            $browser = new WordPress($agent, $logger);
        } elseif (preg_match('/Tiny Tiny RSS/', $agent)) {
            $browser = new TinyTinyRss($agent, $logger);
        } elseif (preg_match('/Readability/', $agent)) {
            $browser = new Readability($agent, $logger);
        } elseif (preg_match('/NSPlayer/', $agent)) {
            $browser = new WindowsMediaPlayer($agent, $logger);
        } elseif (preg_match('/Pingdom/', $agent)) {
            $browser = new Pingdom($agent, $logger);
        } elseif (preg_match('/crazywebcrawler/i', $agent)) {
            $browser = new Crazywebcrawler($agent, $logger);
        } elseif (preg_match('/GG PeekBot/', $agent)) {
            $browser = new GgPeekBot($agent, $logger);
        } elseif (preg_match('/iTunes/', $agent)) {
            $browser = new Itunes($agent, $logger);
        } elseif (preg_match('/LibreOffice/', $agent)) {
            $browser = new LibreOffice($agent, $logger);
        } elseif (preg_match('/OpenOffice/', $agent)) {
            $browser = new OpenOffice($agent, $logger);
        } elseif (preg_match('/ThumbnailAgent/', $agent)) {
            $browser = new ThumbnailAgent($agent, $logger);
        } elseif (preg_match('/LinkStats Bot/', $agent)) {
            $browser = new LinkStatsBot($agent, $logger);
        } elseif (preg_match('/eZ Publish Link Validator/', $agent)) {
            $browser = new EzPublishLinkValidator($agent, $logger);
        } elseif (preg_match('/ThumbSniper/', $agent)) {
            $browser = new ThumbSniper($agent, $logger);
        } elseif (preg_match('/stq\_bot/', $agent)) {
            $browser = new SearchteqBot($agent, $logger);
        } elseif (preg_match('/SNK Screenshot Bot/', $agent)) {
            $browser = new SnkScreenshotBot($agent, $logger);
        } elseif (preg_match('/SynHttpClient/', $agent)) {
            $browser = new SynHttpClient($agent, $logger);
        } elseif (preg_match('/HTTPClient/', $agent)) {
            $browser = new HttpClient($agent, $logger);
        } elseif (preg_match('/T\-Online Browser/', $agent)) {
            $browser = new TonlineBrowser($agent, $logger);
        } elseif (preg_match('/ImplisenseBot/', $agent)) {
            $browser = new ImplisenseBot($agent, $logger);
        } elseif (preg_match('/BuiBui\-Bot/', $agent)) {
            $browser = new BuiBuiBot($agent, $logger);
        } elseif (preg_match('/thumbshots\-de\-bot/', $agent)) {
            $browser = new ThumbShotsDeBot($agent, $logger);
        } elseif (preg_match('/python\-requests/', $agent)) {
            $browser = new PythonRequests($agent, $logger);
        } elseif (preg_match('/Bot\.AraTurka\.com/', $agent)) {
            $browser = new BotAraTurka($agent, $logger);
        } elseif (preg_match('/http\_requester/', $agent)) {
            $browser = new HttpRequester($agent, $logger);
        } elseif (preg_match('/WhatWeb/', $agent)) {
            $browser = new WhatWebWebScanner($agent, $logger);
        } elseif (preg_match('/isc header collector handlers/', $agent)) {
            $browser = new IscHeaderCollectorHandlers($agent, $logger);
        } elseif (preg_match('/Thumbor/', $agent)) {
            $browser = new Thumbor($agent, $logger);
        } elseif (preg_match('/Forum Poster/', $agent)) {
            $browser = new ForumPoster($agent, $logger);
        } elseif (preg_match('/crawler4j/', $agent)) {
            $browser = new Crawler4j($agent, $logger);
        } elseif (preg_match('/Facebot/', $agent)) {
            $browser = new FaceBot($agent, $logger);
        } elseif (preg_match('/Evernote Clip Resolver/', $agent)) {
            $browser = new EvernoteClipResolver($agent, $logger);
        } elseif (preg_match('/NetzCheckBot/', $agent)) {
            $browser = new NetzCheckBot($agent, $logger);
        } elseif (preg_match('/MIB/', $agent)) {
            $browser = new MotorolaInternetBrowser($agent, $logger);
        } elseif (preg_match('/facebookscraper/', $agent)) {
            $browser = new Facebookscraper($agent, $logger);
        } elseif (preg_match('/Zookabot/', $agent)) {
            $browser = new Zookabot($agent, $logger);
        } elseif (preg_match('/MetaURI/', $agent)) {
            $browser = new MetaUri($agent, $logger);
        } elseif (preg_match('/FreeWebMonitoring SiteChecker/', $agent)) {
            $browser = new FreeWebMonitoringSiteChecker($agent, $logger);
        } elseif (preg_match('/IPv4Scan/', $agent)) {
            $browser = new Ipv4Scan($agent, $logger);
        } elseif (preg_match('/RED/', $agent)) {
            $browser = new Redbot($agent, $logger);
        } elseif (preg_match('/domainsbot/', $agent)) {
            $browser = new DomainsBot($agent, $logger);
        } elseif (preg_match('/BUbiNG/', $agent)) {
            $browser = new Bubing($agent, $logger);
        } elseif (preg_match('/RamblerMail/', $agent)) {
            $browser = new RamblerMail($agent, $logger);
        } elseif (preg_match('/ichiro\/mobile/', $agent)) {
            $browser = new IchiroMobileBot($agent, $logger);
        } elseif (preg_match('/ichiro/', $agent)) {
            $browser = new IchiroBot($agent, $logger);
        } elseif (preg_match('/iisbot/', $agent)) {
            $browser = new IisBot($agent, $logger);
        } elseif (preg_match('/JoobleBot/', $agent)) {
            $browser = new JoobleBot($agent, $logger);
        } elseif (preg_match('/Superfeedr bot/', $agent)) {
            $browser = new SuperfeedrBot($agent, $logger);
        } elseif (preg_match('/Icarus6j/', $agent)) {
            $browser = new Icarus6j($agent, $logger);
        } elseif (preg_match('/wsr\-agent/', $agent)) {
            $browser = new WsrAgent($agent, $logger);
        } elseif (preg_match('/Blogshares Spiders/', $agent)) {
            $browser = new BlogsharesSpiders($agent, $logger);
        } elseif (preg_match('/TinEye\-bot/', $agent)) {
            $browser = new TinEyeBot($agent, $logger);
        } elseif (preg_match('/QuickiWiki/', $agent)) {
            $browser = new QuickiWikiBot($agent, $logger);
        } elseif (preg_match('/curl/i', $agent)) {
            $browser = new Curl($agent, $logger);
        } elseif (preg_match('/^PHP/', $agent)) {
            $browser = new Php($agent, $logger);
        } elseif (preg_match('/Apple\-PubSub/', $agent)) {
            $browser = new ApplePubSub($agent, $logger);
        } elseif (preg_match('/SimplePie/', $agent)) {
            $browser = new SimplePie($agent, $logger);
        } elseif (preg_match('/BigBozz/', $agent)) {
            $browser = new BigBozz($agent, $logger);
        } elseif (preg_match('/ECCP/', $agent)) {
            $browser = new Eccp($agent, $logger);
        } elseif (preg_match('/facebookexternalhit/', $agent)) {
            $browser = new FacebookExternalHit($agent, $logger);
        } elseif (preg_match('/GigablastOpenSource/', $agent)) {
            $browser = new GigablastOpenSource($agent, $logger);
        } elseif (preg_match('/WebIndex/', $agent)) {
            $browser = new WebIndex($agent, $logger);
        } elseif (preg_match('/Prince/', $agent)) {
            $browser = new Prince($agent, $logger);
        } elseif (preg_match('/adsense\-snapshot\-google/i', $agent)) {
            $browser = new GoogleAdsenseSnapshot($agent, $logger);
        } elseif (preg_match('/Amazon CloudFront/', $agent)) {
            $browser = new AmazonCloudFront($agent, $logger);
        } elseif (preg_match('/bandscraper/', $agent)) {
            $browser = new Bandscraper($agent, $logger);
        } elseif (preg_match('/bitlybot/', $agent)) {
            $browser = new BitlyBot($agent, $logger);
        } elseif (preg_match('/^bot$/', $agent)) {
            $browser = new BotBot($agent, $logger);
        } elseif (preg_match('/cars\-app\-browser/', $agent)) {
            $browser = new CarsAppBrowser($agent, $logger);
        } elseif (preg_match('/Coursera\-Mobile/', $agent)) {
            $browser = new CourseraMobileApp($agent, $logger);
        } elseif (preg_match('/Crowsnest/', $agent)) {
            $browser = new CrowsnestMobileApp($agent, $logger);
        } elseif (preg_match('/Dorado WAP\-Browser/', $agent)) {
            $browser = new DoradoWapBrowser($agent, $logger);
        } elseif (preg_match('/Goldfire Server/', $agent)) {
            $browser = new GoldfireServer($agent, $logger);
        } elseif (preg_match('/EventMachine HttpClient/', $agent)) {
            $browser = new EventMachineHttpClient($agent, $logger);
        } elseif (preg_match('/iBall/', $agent)) {
            $browser = new Iball($agent, $logger);
        } elseif (preg_match('/InAGist URL Resolver/', $agent)) {
            $browser = new InagistUrlResolver($agent, $logger);
        } elseif (preg_match('/Jeode/', $agent)) {
            $browser = new Jeode($agent, $logger);
        } elseif (preg_match('/kraken/', $agent)) {
            $browser = new Krakenjs($agent, $logger);
        } elseif (preg_match('/com\.linkedin/', $agent)) {
            $browser = new LinkedInBot($agent, $logger);
        } elseif (preg_match('/LivelapBot/', $agent)) {
            $browser = new LivelapBot($agent, $logger);
        } elseif (preg_match('/MixBot/', $agent)) {
            $browser = new MixBot($agent, $logger);
        } elseif (preg_match('/BuSecurityProject/', $agent)) {
            $browser = new BuSecurityProject($agent, $logger);
        } elseif (preg_match('/PageFreezer/', $agent)) {
            $browser = new PageFreezer($agent, $logger);
        } elseif (preg_match('/restify/', $agent)) {
            $browser = new Restify($agent, $logger);
        } elseif (preg_match('/ShowyouBot/', $agent)) {
            $browser = new ShowyouBot($agent, $logger);
        } elseif (preg_match('/vlc/i', $agent)) {
            $browser = new VlcMediaPlayer($agent, $logger);
        } elseif (preg_match('/WebRingChecker/', $agent)) {
            $browser = new WebRingChecker($agent, $logger);
        } elseif (preg_match('/bot\-pge\.chlooe\.com/', $agent)) {
            $browser = new ChlooeBot($agent, $logger);
        } elseif (preg_match('/seebot/', $agent)) {
            $browser = new SeeBot($agent, $logger);
        } elseif (preg_match('/ltx71/', $agent)) {
            $browser = new Ltx71($agent, $logger);
        } elseif (preg_match('/CookieReports/', $agent)) {
            $browser = new CookieReportsBot($agent, $logger);
        } elseif (preg_match('/Elmer/', $agent)) {
            $browser = new Elmer($agent, $logger);
        } elseif (preg_match('/Iframely/', $agent)) {
            $browser = new IframelyBot($agent, $logger);
        } elseif (preg_match('/MetaInspector/', $agent)) {
            $browser = new MetaInspector($agent, $logger);
        } elseif (preg_match('/Microsoft\-CryptoAPI/', $agent)) {
            $browser = new MicrosoftCryptoApi($agent, $logger);
        } elseif (preg_match('/OWASP\_SECRET\_BROWSER/', $agent)) {
            $browser = new OwaspSecretBrowser($agent, $logger);
        } elseif (preg_match('/SMRF URL Expander/', $agent)) {
            $browser = new SmrfUrlExpander($agent, $logger);
        } elseif (preg_match('/Speedy Spider/', $agent)) {
            $browser = new Entireweb($agent, $logger);
        } elseif (preg_match('/Superarama\.com \- BOT/', $agent)) {
            $browser = new SuperaramaComBot($agent, $logger);
        } elseif (preg_match('/WNMbot/', $agent)) {
            $browser = new Wnmbot($agent, $logger);
        } elseif (preg_match('/Website Explorer/', $agent)) {
            $browser = new WebsiteExplorer($agent, $logger);
        } elseif (preg_match('/city\-map screenshot service/', $agent)) {
            $browser = new CitymapScreenshotService($agent, $logger);
        } elseif (preg_match('/gosquared\-thumbnailer/', $agent)) {
            $browser = new GosquaredThumbnailer($agent, $logger);
        } elseif (preg_match('/optivo\(R\) NetHelper/', $agent)) {
            $browser = new OptivoNetHelper($agent, $logger);
        } elseif (preg_match('/pr\-cy\.ru Screenshot Bot/', $agent)) {
            $browser = new ScreenshotBot($agent, $logger);
        } elseif (preg_match('/Cyberduck/', $agent)) {
            $browser = new Cyberduck($agent, $logger);
        } elseif (preg_match('/Lynx/', $agent)) {
            $browser = new Lynx($agent, $logger);
        } elseif (preg_match('/MSFrontPage/', $agent)) {
            $browser = new MicrosoftFrontPage($agent, $logger);
        } elseif (preg_match('/BegunAdvertising/', $agent)) {
            $browser = new BegunAdvertisingBot($agent, $logger);
        } elseif (preg_match('/AccServer/', $agent)) {
            $browser = new AccServer($agent, $logger);
        } elseif (preg_match('/SafeSearch microdata crawler/', $agent)) {
            $browser = new SafeSearchMicrodataCrawler($agent, $logger);
        } elseif (preg_match('/iZSearch/', $agent)) {
            $browser = new IzSearchBot($agent, $logger);
        } elseif (preg_match('/NetLyzer FastProbe/', $agent)) {
            $browser = new NetLyzerFastProbe($agent, $logger);
        } elseif (preg_match('/java/i', $agent)) {
            $browser = new JavaStandardLibrary($agent, $logger);
        } else {
            $browser = new UnknownBrowser($agent, $logger);
        }

        $browser->setCache($cache);

        return $browser;
    }
}
