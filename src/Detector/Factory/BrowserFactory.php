<?php
/**
 * Copyright (c) 2012-2016, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
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
 *
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 *
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Detector\Factory;

use BrowserDetector\Detector\Browser\A6Indexer;
use BrowserDetector\Detector\Browser\AbontiBot;
use BrowserDetector\Detector\Browser\Aboundexbot;
use BrowserDetector\Detector\Browser\AboutUsBot;
use BrowserDetector\Detector\Browser\AboutUsBotJohnny5;
use BrowserDetector\Detector\Browser\Abrowse;
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
use BrowserDetector\Detector\Browser\AlexaSiteAudit;
use BrowserDetector\Detector\Browser\AlltopApp;
use BrowserDetector\Detector\Browser\AmazonCloudFront;
use BrowserDetector\Detector\Browser\Amigo;
use BrowserDetector\Detector\Browser\AndroidDownloadManager;
use BrowserDetector\Detector\Browser\AndroidWebkit;
use BrowserDetector\Detector\Browser\AndroidWebView;
use BrowserDetector\Detector\Browser\AnotherWebMiningTool;
use BrowserDetector\Detector\Browser\AntBot;
use BrowserDetector\Detector\Browser\AolBot;
use BrowserDetector\Detector\Browser\ApacheSynapse;
use BrowserDetector\Detector\Browser\Apercite;
use BrowserDetector\Detector\Browser\AppleAppStoreApp;
use BrowserDetector\Detector\Browser\Applebot;
use BrowserDetector\Detector\Browser\AppleCoreMedia;
use BrowserDetector\Detector\Browser\AppleMail;
use BrowserDetector\Detector\Browser\ApplePubSub;
use BrowserDetector\Detector\Browser\AptHttpTransport;
use BrowserDetector\Detector\Browser\ApusBrowser;
use BrowserDetector\Detector\Browser\ArachnidaWebCrawler;
use BrowserDetector\Detector\Browser\ArchiveBot;
use BrowserDetector\Detector\Browser\ArchiveOrgBot;
use BrowserDetector\Detector\Browser\Arora;
use BrowserDetector\Detector\Browser\AskPeterBot;
use BrowserDetector\Detector\Browser\AstuteSocial;
use BrowserDetector\Detector\Browser\AsynchronousHttpClient;
use BrowserDetector\Detector\Browser\AthenaSiteAnalyzer;
use BrowserDetector\Detector\Browser\AtomicBrowser;
use BrowserDetector\Detector\Browser\AuditmypcWebmasterTool;
use BrowserDetector\Detector\Browser\Avant;
use BrowserDetector\Detector\Browser\AvastSafeZone;
use BrowserDetector\Detector\Browser\BacklinkCrawler;
use BrowserDetector\Detector\Browser\BaiduBoxApp;
use BrowserDetector\Detector\Browser\BaiduBrowser;
use BrowserDetector\Detector\Browser\BaiduHdBrowser;
use BrowserDetector\Detector\Browser\BaiduImageSearch;
use BrowserDetector\Detector\Browser\BaiduMiniBrowser;
use BrowserDetector\Detector\Browser\BaiduMobileSearch;
use BrowserDetector\Detector\Browser\Bandscraper;
use BrowserDetector\Detector\Browser\BckLinks;
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
use BrowserDetector\Detector\Browser\Bot360;
use BrowserDetector\Detector\Browser\Bot80Legs;
use BrowserDetector\Detector\Browser\BotAraTurka;
use BrowserDetector\Detector\Browser\BotBot;
use BrowserDetector\Detector\Browser\BotForJce;
use BrowserDetector\Detector\Browser\BotRevolt;
use BrowserDetector\Detector\Browser\Bowser;
use BrowserDetector\Detector\Browser\BrokenLinkCheck;
use BrowserDetector\Detector\Browser\Browser2345;
use BrowserDetector\Detector\Browser\Browsershots;
use BrowserDetector\Detector\Browser\Bubing;
use BrowserDetector\Detector\Browser\BuiBuiBot;
use BrowserDetector\Detector\Browser\BuSecurityProject;
use BrowserDetector\Detector\Browser\ButterflyRobot;
use BrowserDetector\Detector\Browser\CaCrawler;
use BrowserDetector\Detector\Browser\Camino;
use BrowserDetector\Detector\Browser\CamoAssetProxy;
use BrowserDetector\Detector\Browser\CareerBot;
use BrowserDetector\Detector\Browser\CarsAppBrowser;
use BrowserDetector\Detector\Browser\CcBot;
use BrowserDetector\Detector\Browser\CfNetwork;
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
use BrowserDetector\Detector\Browser\CometBird;
use BrowserDetector\Detector\Browser\ComodoDragon;
use BrowserDetector\Detector\Browser\ComodoIceDragon;
use BrowserDetector\Detector\Browser\ComodoSpider;
use BrowserDetector\Detector\Browser\ContextadBot;
use BrowserDetector\Detector\Browser\CookieReportsBot;
use BrowserDetector\Detector\Browser\CoolNovo;
use BrowserDetector\Detector\Browser\CoolNovoChromePlus;
use BrowserDetector\Detector\Browser\CourseraMobileApp;
use BrowserDetector\Detector\Browser\Crawler;
use BrowserDetector\Detector\Browser\Crawler007AC9;
use BrowserDetector\Detector\Browser\Crawler4j;
use BrowserDetector\Detector\Browser\CrawlRobot;
use BrowserDetector\Detector\Browser\CrazyBrowser;
use BrowserDetector\Detector\Browser\Crazywebcrawler;
use BrowserDetector\Detector\Browser\CrowsnestMobileApp;
use BrowserDetector\Detector\Browser\Curb;
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
use BrowserDetector\Detector\Browser\DigincoreBot;
use BrowserDetector\Detector\Browser\Diglo;
use BrowserDetector\Detector\Browser\DiigoBrowser;
use BrowserDetector\Detector\Browser\Dillo;
use BrowserDetector\Detector\Browser\DiscoverEd;
use BrowserDetector\Detector\Browser\DiscoveryBot;
use BrowserDetector\Detector\Browser\Dispatch;
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
use BrowserDetector\Detector\Browser\DuckDuckApp;
use BrowserDetector\Detector\Browser\DuckDuckFaviconsBot;
use BrowserDetector\Detector\Browser\DueDilCrawler;
use BrowserDetector\Detector\Browser\EasouSpider;
use BrowserDetector\Detector\Browser\EasyBibAutoCite;
use BrowserDetector\Detector\Browser\EbApp;
use BrowserDetector\Detector\Browser\Eccp;
use BrowserDetector\Detector\Browser\ElementBrowser;
use BrowserDetector\Detector\Browser\Elinks;
use BrowserDetector\Detector\Browser\ElluminateLive;
use BrowserDetector\Detector\Browser\ElmediaPlayer;
use BrowserDetector\Detector\Browser\Elmer;
use BrowserDetector\Detector\Browser\Embedly;
use BrowserDetector\Detector\Browser\EmbedPhpLibrary;
use BrowserDetector\Detector\Browser\Entireweb;
use BrowserDetector\Detector\Browser\Epiphany;
use BrowserDetector\Detector\Browser\EspialTvBrowser;
use BrowserDetector\Detector\Browser\Esribot;
use BrowserDetector\Detector\Browser\EventMachineHttpClient;
use BrowserDetector\Detector\Browser\EvernoteApp;
use BrowserDetector\Detector\Browser\EvernoteClipResolver;
use BrowserDetector\Detector\Browser\EveryoneSocialBot;
use BrowserDetector\Detector\Browser\Exabot;
use BrowserDetector\Detector\Browser\ExaleadCloudView;
use BrowserDetector\Detector\Browser\Experibot;
use BrowserDetector\Detector\Browser\ExploratodoBot;
use BrowserDetector\Detector\Browser\Ezooms;
use BrowserDetector\Detector\Browser\EzPublishLinkValidator;
use BrowserDetector\Detector\Browser\FacebookApp;
use BrowserDetector\Detector\Browser\FacebookExternalHit;
use BrowserDetector\Detector\Browser\Facebookscraper;
use BrowserDetector\Detector\Browser\FaceBot;
use BrowserDetector\Detector\Browser\Faraday;
use BrowserDetector\Detector\Browser\FastbotCrawler;
use BrowserDetector\Detector\Browser\FastBrowser;
use BrowserDetector\Detector\Browser\FastladderFeedFetcher;
use BrowserDetector\Detector\Browser\FeedBlitz;
use BrowserDetector\Detector\Browser\FeedBurner;
use BrowserDetector\Detector\Browser\FeeddlerRssReader;
use BrowserDetector\Detector\Browser\Feedly;
use BrowserDetector\Detector\Browser\FeedlyApp;
use BrowserDetector\Detector\Browser\Fennec;
use BrowserDetector\Detector\Browser\FhscanCore;
use BrowserDetector\Detector\Browser\FinderleinResearchCrawler;
use BrowserDetector\Detector\Browser\Firefox;
use BrowserDetector\Detector\Browser\FirefoxIos;
use BrowserDetector\Detector\Browser\Flipboard;
use BrowserDetector\Detector\Browser\FlipboardProxy;
use BrowserDetector\Detector\Browser\FlixsterApp;
use BrowserDetector\Detector\Browser\Flock;
use BrowserDetector\Detector\Browser\Fluid;
use BrowserDetector\Detector\Browser\FlyFlow;
use BrowserDetector\Detector\Browser\Focuseekbot;
use BrowserDetector\Detector\Browser\ForumPoster;
use BrowserDetector\Detector\Browser\FrCrawler;
use BrowserDetector\Detector\Browser\FreeWebMonitoringSiteChecker;
use BrowserDetector\Detector\Browser\Friendica;
use BrowserDetector\Detector\Browser\Galeon;
use BrowserDetector\Detector\Browser\GarlikCrawler;
use BrowserDetector\Detector\Browser\Genderanalyzer;
use BrowserDetector\Detector\Browser\Gettor;
use BrowserDetector\Detector\Browser\GgPeekBot;
use BrowserDetector\Detector\Browser\GidBot;
use BrowserDetector\Detector\Browser\GigablastOpenSource;
use BrowserDetector\Detector\Browser\GlBot;
use BrowserDetector\Detector\Browser\GoHttpClient;
use BrowserDetector\Detector\Browser\GoldfireServer;
use BrowserDetector\Detector\Browser\GomezSiteMonitor;
use BrowserDetector\Detector\Browser\GooBlog;
use BrowserDetector\Detector\Browser\GoogleAdsbotMobile;
use BrowserDetector\Detector\Browser\GoogleAdSenseBot;
use BrowserDetector\Detector\Browser\GoogleAdsenseSnapshot;
use BrowserDetector\Detector\Browser\GoogleAdwordsDisplayAdsWebRender;
use BrowserDetector\Detector\Browser\GoogleApp;
use BrowserDetector\Detector\Browser\GoogleAppEngine;
use BrowserDetector\Detector\Browser\Googlebot;
use BrowserDetector\Detector\Browser\GooglebotMobileBot;
use BrowserDetector\Detector\Browser\GoogleDesktop;
use BrowserDetector\Detector\Browser\GoogleFeedfetcher;
use BrowserDetector\Detector\Browser\GoogleHttpClientLibraryForJava;
use BrowserDetector\Detector\Browser\GoogleImageSearch;
use BrowserDetector\Detector\Browser\GoogleKeywordSuggestion;
use BrowserDetector\Detector\Browser\GooglePageSpeedInsights;
use BrowserDetector\Detector\Browser\GooglePlus;
use BrowserDetector\Detector\Browser\GoogleSiteVerification;
use BrowserDetector\Detector\Browser\GoogleStructuredDataTestingTool;
use BrowserDetector\Detector\Browser\GoogleToolbar;
use BrowserDetector\Detector\Browser\GoogleWebPreview;
use BrowserDetector\Detector\Browser\GoogleWebSnippet;
use BrowserDetector\Detector\Browser\GoogleWirelessTranscoder;
use BrowserDetector\Detector\Browser\GooseExtractor;
use BrowserDetector\Detector\Browser\GosquaredThumbnailer;
use BrowserDetector\Detector\Browser\Grammarly;
use BrowserDetector\Detector\Browser\GrapeFx;
use BrowserDetector\Detector\Browser\GrapeshotCrawler;
use BrowserDetector\Detector\Browser\GroupHighBot;
use BrowserDetector\Detector\Browser\GuzzleHttpClient;
use BrowserDetector\Detector\Browser\Gvfs;
use BrowserDetector\Detector\Browser\GwpImages;
use BrowserDetector\Detector\Browser\HatenaBookmark;
use BrowserDetector\Detector\Browser\HgghPhantomjsScreenshoter;
use BrowserDetector\Detector\Browser\HivaBot;
use BrowserDetector\Detector\Browser\HrCrawler;
use BrowserDetector\Detector\Browser\HttpClient;
use BrowserDetector\Detector\Browser\HttpKit;
use BrowserDetector\Detector\Browser\HttpRequester;
use BrowserDetector\Detector\Browser\Httrack;
use BrowserDetector\Detector\Browser\HubSpotWebcrawler;
use BrowserDetector\Detector\Browser\HyperCrawl;
use BrowserDetector\Detector\Browser\Iball;
use BrowserDetector\Detector\Browser\IbmConnections;
use BrowserDetector\Detector\Browser\IbooksAuthor;
use BrowserDetector\Detector\Browser\IBrowser;
use BrowserDetector\Detector\Browser\Icab;
use BrowserDetector\Detector\Browser\IcabMobile;
use BrowserDetector\Detector\Browser\Icarus6j;
use BrowserDetector\Detector\Browser\IccCrawler;
use BrowserDetector\Detector\Browser\Iceape;
use BrowserDetector\Detector\Browser\IceCat;
use BrowserDetector\Detector\Browser\Iceweasel;
use BrowserDetector\Detector\Browser\IchiroBot;
use BrowserDetector\Detector\Browser\IchiroMobileBot;
use BrowserDetector\Detector\Browser\IframelyBot;
use BrowserDetector\Detector\Browser\IisBot;
use BrowserDetector\Detector\Browser\ImplisenseBot;
use BrowserDetector\Detector\Browser\InagistUrlResolver;
use BrowserDetector\Detector\Browser\InfegyAtlasBot;
use BrowserDetector\Detector\Browser\InfoxWisg;
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
use BrowserDetector\Detector\Browser\JobBoerseBot;
use BrowserDetector\Detector\Browser\JobdiggerSpider;
use BrowserDetector\Detector\Browser\JobRoboter;
use BrowserDetector\Detector\Browser\JoobleBot;
use BrowserDetector\Detector\Browser\Jupdate;
use BrowserDetector\Detector\Browser\KamelioApp;
use BrowserDetector\Detector\Browser\Kazehakase;
use BrowserDetector\Detector\Browser\Kenshoo;
use BrowserDetector\Detector\Browser\Kgbody;
use BrowserDetector\Detector\Browser\Kinza;
use BrowserDetector\Detector\Browser\Kizasispider;
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
use BrowserDetector\Detector\Browser\Libcurl;
use BrowserDetector\Detector\Browser\LibreOffice;
use BrowserDetector\Detector\Browser\Libwww;
use BrowserDetector\Detector\Browser\Liebao;
use BrowserDetector\Detector\Browser\LightspeedSystemsCrawler;
use BrowserDetector\Detector\Browser\LightspeedSystemsRocketCrawler;
use BrowserDetector\Detector\Browser\LinkCheck;
use BrowserDetector\Detector\Browser\LinkdexBot;
use BrowserDetector\Detector\Browser\LinkedInBot;
use BrowserDetector\Detector\Browser\LinkpadBot;
use BrowserDetector\Detector\Browser\Links;
use BrowserDetector\Detector\Browser\LinksCrawler;
use BrowserDetector\Detector\Browser\LinkStatsBot;
use BrowserDetector\Detector\Browser\LinkThumbnailer;
use BrowserDetector\Detector\Browser\LipperheyKausAustralis;
use BrowserDetector\Detector\Browser\LipperheySeoService;
use BrowserDetector\Detector\Browser\LivedoorFeedFetcher;
use BrowserDetector\Detector\Browser\LivelapBot;
use BrowserDetector\Detector\Browser\LoadTimeBot;
use BrowserDetector\Detector\Browser\Locubot;
use BrowserDetector\Detector\Browser\LongUrlBot;
use BrowserDetector\Detector\Browser\LotusNotes;
use BrowserDetector\Detector\Browser\Ltx71;
use BrowserDetector\Detector\Browser\Luakit;
use BrowserDetector\Detector\Browser\LucidworksBot;
use BrowserDetector\Detector\Browser\Lunascape;
use BrowserDetector\Detector\Browser\Lynx;
use BrowserDetector\Detector\Browser\MacAppStore;
use BrowserDetector\Detector\Browser\MagpieRss;
use BrowserDetector\Detector\Browser\MailBar;
use BrowserDetector\Detector\Browser\MailChimp;
use BrowserDetector\Detector\Browser\MailRu;
use BrowserDetector\Detector\Browser\MarketingGrader;
use BrowserDetector\Detector\Browser\MarketwireBot;
use BrowserDetector\Detector\Browser\MauiWapBrowser;
use BrowserDetector\Detector\Browser\Maxthon;
use BrowserDetector\Detector\Browser\MaxthonNitro;
use BrowserDetector\Detector\Browser\Mbot;
use BrowserDetector\Detector\Browser\MeanpathBot;
use BrowserDetector\Detector\Browser\MegaIndexBot;
use BrowserDetector\Detector\Browser\MelvilBot;
use BrowserDetector\Detector\Browser\MelvilFaviconBot;
use BrowserDetector\Detector\Browser\MemoryBot;
use BrowserDetector\Detector\Browser\MerchantCentricBot;
use BrowserDetector\Detector\Browser\Mercury;
use BrowserDetector\Detector\Browser\MetaGeneratorCrawler;
use BrowserDetector\Detector\Browser\Metager2VerificationBot;
use BrowserDetector\Detector\Browser\MetaHeadersBot;
use BrowserDetector\Detector\Browser\MetaInspector;
use BrowserDetector\Detector\Browser\MetaJobBot;
use BrowserDetector\Detector\Browser\MetaUri;
use BrowserDetector\Detector\Browser\MicroB;
use BrowserDetector\Detector\Browser\MicrosoftAccess;
use BrowserDetector\Detector\Browser\MicrosoftCryptoApi;
use BrowserDetector\Detector\Browser\MicrosoftDotNetFrameworkClr;
use BrowserDetector\Detector\Browser\MicrosoftEdge;
use BrowserDetector\Detector\Browser\MicrosoftEdgeMobile;
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
use BrowserDetector\Detector\Browser\Minimo;
use BrowserDetector\Detector\Browser\MiuiBrowser;
use BrowserDetector\Detector\Browser\MixBot;
use BrowserDetector\Detector\Browser\MixrankBot;
use BrowserDetector\Detector\Browser\Mj12bot;
use BrowserDetector\Detector\Browser\MnogoSearch;
use BrowserDetector\Detector\Browser\MobileSafariUiWebView;
use BrowserDetector\Detector\Browser\ModelsBrowser;
use BrowserDetector\Detector\Browser\MojeekBot;
use BrowserDetector\Detector\Browser\MonoBot;
use BrowserDetector\Detector\Browser\Moozilla;
use BrowserDetector\Detector\Browser\Moreover;
use BrowserDetector\Detector\Browser\MosBookmarks;
use BrowserDetector\Detector\Browser\MosBookmarksLinkChecker;
use BrowserDetector\Detector\Browser\MotorolaInternetBrowser;
use BrowserDetector\Detector\Browser\MozillaCrawler;
use BrowserDetector\Detector\Browser\MsnBotMedia;
use BrowserDetector\Detector\Browser\MultiZilla;
use BrowserDetector\Detector\Browser\MyInternetBrowser;
use BrowserDetector\Detector\Browser\Nagios;
use BrowserDetector\Detector\Browser\NaverBot;
use BrowserDetector\Detector\Browser\NaverMatome;
use BrowserDetector\Detector\Browser\Nbot;
use BrowserDetector\Detector\Browser\NerdyBot;
use BrowserDetector\Detector\Browser\NetEstateCrawler;
use BrowserDetector\Detector\Browser\NetFront;
use BrowserDetector\Detector\Browser\NetFrontLifeBrowser;
use BrowserDetector\Detector\Browser\NetFrontNx;
use BrowserDetector\Detector\Browser\NetLyzerFastProbe;
use BrowserDetector\Detector\Browser\Netscape;
use BrowserDetector\Detector\Browser\NetscapeNavigator;
use BrowserDetector\Detector\Browser\NetseerCrawler;
use BrowserDetector\Detector\Browser\NettioBot;
use BrowserDetector\Detector\Browser\NetzCheckBot;
use BrowserDetector\Detector\Browser\NewsBlurFeedFetcher;
use BrowserDetector\Detector\Browser\NewsFire;
use BrowserDetector\Detector\Browser\NewsMe;
use BrowserDetector\Detector\Browser\Newspaper;
use BrowserDetector\Detector\Browser\Nichrome;
use BrowserDetector\Detector\Browser\NikiBot;
use BrowserDetector\Detector\Browser\NineConnections;
use BrowserDetector\Detector\Browser\Ning;
use BrowserDetector\Detector\Browser\NodeFetch;
use BrowserDetector\Detector\Browser\NokiaBrowser;
use BrowserDetector\Detector\Browser\NokiaProxyBrowser;
use BrowserDetector\Detector\Browser\NoteTextView;
use BrowserDetector\Detector\Browser\Nutch;
use BrowserDetector\Detector\Browser\ObigoQ;
use BrowserDetector\Detector\Browser\Obot;
use BrowserDetector\Detector\Browser\OktaMobileApp;
use BrowserDetector\Detector\Browser\Omniweb;
use BrowserDetector\Detector\Browser\OneBrowser;
use BrowserDetector\Detector\Browser\OpenBsdFtp;
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
use BrowserDetector\Detector\Browser\Orangebot;
use BrowserDetector\Detector\Browser\Otter;
use BrowserDetector\Detector\Browser\OwaspSecretBrowser;
use BrowserDetector\Detector\Browser\OwlerBot;
use BrowserDetector\Detector\Browser\PadBot;
use BrowserDetector\Detector\Browser\PageFreezer;
use BrowserDetector\Detector\Browser\PagePeeker;
use BrowserDetector\Detector\Browser\PagePeekerScreenshotMaker;
use BrowserDetector\Detector\Browser\PagesInventoryBot;
use BrowserDetector\Detector\Browser\Palemoon;
use BrowserDetector\Detector\Browser\PaperLiBot;
use BrowserDetector\Detector\Browser\PdrlabsBot;
use BrowserDetector\Detector\Browser\PearltreesBot;
use BrowserDetector\Detector\Browser\PeeploScreenshotBot;
use BrowserDetector\Detector\Browser\PerfectBrowser;
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
use BrowserDetector\Detector\Browser\Please200Bot;
use BrowserDetector\Detector\Browser\Plus5Bot;
use BrowserDetector\Detector\Browser\PmozinfoOdpLinkChecker;
use BrowserDetector\Detector\Browser\Polaris;
use BrowserDetector\Detector\Browser\PostRank;
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
use BrowserDetector\Detector\Browser\PyCurl;
use BrowserDetector\Detector\Browser\PythonRequests;
use BrowserDetector\Detector\Browser\PythonUrlLib;
use BrowserDetector\Detector\Browser\QqBrowser;
use BrowserDetector\Detector\Browser\QqBrowserMini;
use BrowserDetector\Detector\Browser\Qt;
use BrowserDetector\Detector\Browser\QualidatorBot;
use BrowserDetector\Detector\Browser\QuickiWikiBot;
use BrowserDetector\Detector\Browser\QuickLook;
use BrowserDetector\Detector\Browser\QuoraApp;
use BrowserDetector\Detector\Browser\QuoraLinkPreviewBot;
use BrowserDetector\Detector\Browser\QupZilla;
use BrowserDetector\Detector\Browser\QuteBrowser;
use BrowserDetector\Detector\Browser\Qwantify;
use BrowserDetector\Detector\Browser\QwordBrowser;
use BrowserDetector\Detector\Browser\R6CommentReader;
use BrowserDetector\Detector\Browser\R6Feedfetcher;
use BrowserDetector\Detector\Browser\RamblerMail;
use BrowserDetector\Detector\Browser\RankFlex;
use BrowserDetector\Detector\Browser\RavenLinkChecker;
use BrowserDetector\Detector\Browser\Readability;
use BrowserDetector\Detector\Browser\RebelMouse;
use BrowserDetector\Detector\Browser\Redbot;
use BrowserDetector\Detector\Browser\RedditPicScraper;
use BrowserDetector\Detector\Browser\Reeder;
use BrowserDetector\Detector\Browser\Rekonq;
use BrowserDetector\Detector\Browser\Restify;
use BrowserDetector\Detector\Browser\RevIpSnfoSiteAnalyzer;
use BrowserDetector\Detector\Browser\Riddler;
use BrowserDetector\Detector\Browser\RivalIqBot;
use BrowserDetector\Detector\Browser\RmSnapKit;
use BrowserDetector\Detector\Browser\Rockmelt;
use BrowserDetector\Detector\Browser\RockyChatWorkMobile;
use BrowserDetector\Detector\Browser\Rogerbot;
use BrowserDetector\Detector\Browser\RokuDvp;
use BrowserDetector\Detector\Browser\RorSitemapGenerator;
use BrowserDetector\Detector\Browser\Rss2Html;
use BrowserDetector\Detector\Browser\Ruby;
use BrowserDetector\Detector\Browser\Safari;
use BrowserDetector\Detector\Browser\Safeassign;
use BrowserDetector\Detector\Browser\SafeSearchMicrodataCrawler;
use BrowserDetector\Detector\Browser\SailfishBrowser;
use BrowserDetector\Detector\Browser\SalesForceApp;
use BrowserDetector\Detector\Browser\SamsungBrowser;
use BrowserDetector\Detector\Browser\SamsungWebView;
use BrowserDetector\Detector\Browser\Sandvox;
use BrowserDetector\Detector\Browser\SchoolwiresApp;
use BrowserDetector\Detector\Browser\ScopiaCrawler;
use BrowserDetector\Detector\Browser\Scoutjet;
use BrowserDetector\Detector\Browser\ScrapyBot;
use BrowserDetector\Detector\Browser\ScreamingFrogSeoSpider;
use BrowserDetector\Detector\Browser\ScreenerBot;
use BrowserDetector\Detector\Browser\ScreenshotBot;
use BrowserDetector\Detector\Browser\Scrubby;
use BrowserDetector\Detector\Browser\Seamonkey;
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
use BrowserDetector\Detector\Browser\SeoStats;
use BrowserDetector\Detector\Browser\SetLinksCrawler;
use BrowserDetector\Detector\Browser\SeznamBot;
use BrowserDetector\Detector\Browser\SeznamBrowser;
use BrowserDetector\Detector\Browser\SeznamScreenshotGenerator;
use BrowserDetector\Detector\Browser\Sharp;
use BrowserDetector\Detector\Browser\ShortLinkTranslate;
use BrowserDetector\Detector\Browser\ShortUrlChecker;
use BrowserDetector\Detector\Browser\ShowyouBot;
use BrowserDetector\Detector\Browser\Shrook;
use BrowserDetector\Detector\Browser\Silk;
use BrowserDetector\Detector\Browser\SimplePie;
use BrowserDetector\Detector\Browser\Sistrix;
use BrowserDetector\Detector\Browser\SiteCon;
use BrowserDetector\Detector\Browser\SiteExplorer;
use BrowserDetector\Detector\Browser\Skyfire;
use BrowserDetector\Detector\Browser\SkypeUriPreview;
use BrowserDetector\Detector\Browser\Slackbot;
use BrowserDetector\Detector\Browser\SlackbotLinkExpanding;
use BrowserDetector\Detector\Browser\Sleipnir;
use BrowserDetector\Detector\Browser\SlimerJs;
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
use BrowserDetector\Detector\Browser\SophosAgent;
use BrowserDetector\Detector\Browser\SophosUpdateManager;
use BrowserDetector\Detector\Browser\SoundCloudApp;
use BrowserDetector\Detector\Browser\SpeedBrowser360;
use BrowserDetector\Detector\Browser\Spinn3rRssAggregator;
use BrowserDetector\Detector\Browser\Spip;
use BrowserDetector\Detector\Browser\SprinklrBot;
use BrowserDetector\Detector\Browser\Squzer;
use BrowserDetector\Detector\Browser\SreleaseBot;
use BrowserDetector\Detector\Browser\SsearchCrawler;
use BrowserDetector\Detector\Browser\Stagefright;
use BrowserDetector\Detector\Browser\Steeler;
use BrowserDetector\Detector\Browser\StratagemsKumo;
use BrowserDetector\Detector\Browser\Superagent;
use BrowserDetector\Detector\Browser\SuperaramaComBot;
use BrowserDetector\Detector\Browser\SuperBird;
use BrowserDetector\Detector\Browser\SuperfeedrBot;
use BrowserDetector\Detector\Browser\SurveyBot;
use BrowserDetector\Detector\Browser\SvvenSummarizerBot;
use BrowserDetector\Detector\Browser\SymfonyRssReader;
use BrowserDetector\Detector\Browser\SynHttpClient;
use BrowserDetector\Detector\Browser\TaprootBot;
use BrowserDetector\Detector\Browser\TelecaObigo;
use BrowserDetector\Detector\Browser\TestCertificateInfo;
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
use BrowserDetector\Detector\Browser\Traackr;
use BrowserDetector\Detector\Browser\TrendWinHttp;
use BrowserDetector\Detector\Browser\TroveBot;
use BrowserDetector\Detector\Browser\TubeTv;
use BrowserDetector\Detector\Browser\TumblrApp;
use BrowserDetector\Detector\Browser\TwcSportsNet;
use BrowserDetector\Detector\Browser\TweetedTimesBot;
use BrowserDetector\Detector\Browser\TweetmemeBot;
use BrowserDetector\Detector\Browser\TweetminsterBot;
use BrowserDetector\Detector\Browser\TwikleBot;
use BrowserDetector\Detector\Browser\TwinglyRecon;
use BrowserDetector\Detector\Browser\TwitterApp;
use BrowserDetector\Detector\Browser\Twitterbot;
use BrowserDetector\Detector\Browser\Typhoeus;
use BrowserDetector\Detector\Browser\Typo3Linkvalidator;
use BrowserDetector\Detector\Browser\UcBrowser;
use BrowserDetector\Detector\Browser\UcBrowserHd;
use BrowserDetector\Detector\Browser\Uipbot;
use BrowserDetector\Detector\Browser\UmBot;
use BrowserDetector\Detector\Browser\Unisterbot;
use BrowserDetector\Detector\Browser\UnisterTesting;
use BrowserDetector\Detector\Browser\UnityWebPlayer;
use BrowserDetector\Detector\Browser\UniventionCorporateServer;
use BrowserDetector\Detector\Browser\UniversalFeedParser;
use BrowserDetector\Detector\Browser\UnknownBrowser;
use BrowserDetector\Detector\Browser\UnwindFetchor;
use BrowserDetector\Detector\Browser\UrlAppendBot;
use BrowserDetector\Detector\Browser\UrlChecker;
use BrowserDetector\Detector\Browser\UrlfilterDbCrawler;
use BrowserDetector\Detector\Browser\UrlGrabber;
use BrowserDetector\Detector\Browser\Vagabondo;
use BrowserDetector\Detector\Browser\VbulletinSeoBot;
use BrowserDetector\Detector\Browser\ViralvideochartBot;
use BrowserDetector\Detector\Browser\Virtuoso;
use BrowserDetector\Detector\Browser\VisionUtils;
use BrowserDetector\Detector\Browser\Vivaldi;
use BrowserDetector\Detector\Browser\VkShare;
use BrowserDetector\Detector\Browser\VlcMediaPlayer;
use BrowserDetector\Detector\Browser\VocusBot;
use BrowserDetector\Detector\Browser\Vsentry;
use BrowserDetector\Detector\Browser\W3cI18nChecker;
use BrowserDetector\Detector\Browser\W3cUnicorn;
use BrowserDetector\Detector\Browser\W3cValidatorNuLv;
use BrowserDetector\Detector\Browser\WadavnSearchBot;
use BrowserDetector\Detector\Browser\WapBrowser;
use BrowserDetector\Detector\Browser\WasaLiveBot;
use BrowserDetector\Detector\Browser\WaterFox;
use BrowserDetector\Detector\Browser\WaybackArchive;
use BrowserDetector\Detector\Browser\WbSearchBot;
use BrowserDetector\Detector\Browser\WdgHtmlValidator;
use BrowserDetector\Detector\Browser\WebceoBot;
use BrowserDetector\Detector\Browser\WebClip;
use BrowserDetector\Detector\Browser\WebCorp;
use BrowserDetector\Detector\Browser\WebdeMailCheck;
use BrowserDetector\Detector\Browser\WebGlance;
use BrowserDetector\Detector\Browser\WebIndex;
use BrowserDetector\Detector\Browser\WebkitWebos;
use BrowserDetector\Detector\Browser\WebMasterAid;
use BrowserDetector\Detector\Browser\WebmasterCoffee;
use BrowserDetector\Detector\Browser\WebmasterTipsBot;
use BrowserDetector\Detector\Browser\WebnumbrFetcher;
use BrowserDetector\Detector\Browser\WebRingChecker;
use BrowserDetector\Detector\Browser\WebsiteExplorer;
use BrowserDetector\Detector\Browser\WebsiteThumbnailGenerator;
use BrowserDetector\Detector\Browser\WebTarantula;
use BrowserDetector\Detector\Browser\WebThumb;
use BrowserDetector\Detector\Browser\WeChatApp;
use BrowserDetector\Detector\Browser\WerbefreieDeutscheSuchmaschine;
use BrowserDetector\Detector\Browser\WeseeAds;
use BrowserDetector\Detector\Browser\WeseeSearch;
use BrowserDetector\Detector\Browser\WeTabBrowser;
use BrowserDetector\Detector\Browser\Wget;
use BrowserDetector\Detector\Browser\WhatsApp;
use BrowserDetector\Detector\Browser\WhatWebWebScanner;
use BrowserDetector\Detector\Browser\WhiteHatAviator;
use BrowserDetector\Detector\Browser\WindowsLiveMail;
use BrowserDetector\Detector\Browser\WindowsMediaPlayer;
use BrowserDetector\Detector\Browser\WindowsPhoneSearch;
use BrowserDetector\Detector\Browser\WindowsRssPlatform;
use BrowserDetector\Detector\Browser\WindowsUpdateAgent;
use BrowserDetector\Detector\Browser\WinHttpRequest;
use BrowserDetector\Detector\Browser\WireApp;
use BrowserDetector\Detector\Browser\WiseNutSearchEngineCrawler;
use BrowserDetector\Detector\Browser\WkBrowser;
use BrowserDetector\Detector\Browser\WkHtmltoImage;
use BrowserDetector\Detector\Browser\WkHtmltopdf;
use BrowserDetector\Detector\Browser\Wnmbot;
use BrowserDetector\Detector\Browser\WooRank;
use BrowserDetector\Detector\Browser\WordPress;
use BrowserDetector\Detector\Browser\WordPressApp;
use BrowserDetector\Detector\Browser\Woriobot;
use BrowserDetector\Detector\Browser\WorldwebheritageBot;
use BrowserDetector\Detector\Browser\WscheckBot;
use BrowserDetector\Detector\Browser\WsrAgent;
use BrowserDetector\Detector\Browser\XenusLinkSleuth;
use BrowserDetector\Detector\Browser\XingContenttabreceiver;
use BrowserDetector\Detector\Browser\XmlSitemapGenerator;
use BrowserDetector\Detector\Browser\XmlSitemapsGenerator;
use BrowserDetector\Detector\Browser\XoviBot;
use BrowserDetector\Detector\Browser\YaBrowser;
use BrowserDetector\Detector\Browser\YahooAdMonitoring;
use BrowserDetector\Detector\Browser\YahooApp;
use BrowserDetector\Detector\Browser\YahooCacheSystem;
use BrowserDetector\Detector\Browser\YahooJapan;
use BrowserDetector\Detector\Browser\YahooLinkPreview;
use BrowserDetector\Detector\Browser\YahooMobileApp;
use BrowserDetector\Detector\Browser\YahooSlingstone;
use BrowserDetector\Detector\Browser\YahooSlurp;
use BrowserDetector\Detector\Browser\YandexBot;
use BrowserDetector\Detector\Browser\YioopBot;
use BrowserDetector\Detector\Browser\YisouSpider;
use BrowserDetector\Detector\Browser\YoozBot;
use BrowserDetector\Detector\Browser\Yourls;
use BrowserDetector\Detector\Browser\ZendHttpClient;
use BrowserDetector\Detector\Browser\ZetakeyBrowser;
use BrowserDetector\Detector\Browser\Zitebot;
use BrowserDetector\Detector\Browser\ZmEu;
use BrowserDetector\Detector\Browser\ZnajdzFotoImageBot;
use BrowserDetector\Detector\Browser\ZollardWorm;
use BrowserDetector\Detector\Browser\Zookabot;
use BrowserDetector\Detector\Browser\ZumBot;
use UaResult\Os\OsInterface;

/**
 * Browser detection class
 *
 * @category  BrowserDetector
 *
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class BrowserFactory implements FactoryInterface
{
    /**
     * Gets the information about the rendering engine by User Agent
     *
     * @param string                   $useragent
     * @param \UaResult\Os\OsInterface $platform
     *
     * @return \BrowserDetector\Detector\Browser\AbstractBrowser
     */
    public static function detect(
        $useragent,
        OsInterface $platform = null
    ) {
        if (preg_match('/RevIP\.info site analyzer/', $useragent)) {
            $browser = new RevIpSnfoSiteAnalyzer($useragent, []);
        } elseif (preg_match('/reddit pic scraper/i', $useragent)) {
            $browser = new RedditPicScraper($useragent, []);
        } elseif (preg_match('/Mozilla crawl/', $useragent)) {
            $browser = new MozillaCrawler($useragent, []);
        } elseif (preg_match('/^\[FBAN/i', $useragent)) {
            $browser = new FacebookApp($useragent, []);
        } elseif (preg_match('/UCBrowserHD/', $useragent)) {
            $browser = new UcBrowserHd($useragent, []);
        } elseif (preg_match('/(ucbrowser|uc browser|ucweb)/i', $useragent) && preg_match('/opera mini/i', $useragent)) {
            $browser = new UcBrowser($useragent, []);
        } elseif (preg_match('/(opera mini|opios)/i', $useragent)) {
            $browser = new OperaMini($useragent, []);
        } elseif (preg_match('/opera mobi/i', $useragent)
            || (preg_match('/(opera|opr)/i', $useragent) && preg_match('/(Android|MTK|MAUI|SAMSUNG|Windows CE|SymbOS)/', $useragent))
        ) {
            $browser = new OperaMobile($useragent, []);
        } elseif (preg_match('/(ucbrowser|uc browser|ucweb)/i', $useragent)) {
            $browser = new UcBrowser($useragent, []);
        } elseif (preg_match('/IC OpenGraph Crawler/', $useragent)) {
            $browser = new IbmConnections($useragent, []);
        } elseif (preg_match('/coast/i', $useragent)) {
            $browser = new OperaCoast($useragent, []);
        } elseif (preg_match('/(opera|opr)/i', $useragent)) {
            $browser = new Opera($useragent, []);
        } elseif (preg_match('/iCabMobile/', $useragent)) {
            $browser = new IcabMobile($useragent, []);
        } elseif (preg_match('/iCab/', $useragent)) {
            $browser = new Icab($useragent, []);
        } elseif (preg_match('/HggH PhantomJS Screenshoter/', $useragent)) {
            $browser = new HgghPhantomjsScreenshoter($useragent, []);
        } elseif (preg_match('/bl\.uk\_lddc\_bot/', $useragent)) {
            $browser = new BlukLddcBot($useragent, []);
        } elseif (preg_match('/phantomas/', $useragent)) {
            $browser = new Phantomas($useragent, []);
        } elseif (preg_match('/Seznam screenshot\-generator/', $useragent)) {
            $browser = new SeznamScreenshotGenerator($useragent, []);
        } elseif (false !== strpos($useragent, 'PhantomJS')) {
            $browser = new PhantomJs($useragent, []);
        } elseif (false !== strpos($useragent, 'YaBrowser')) {
            $browser = new YaBrowser($useragent, []);
        } elseif (false !== strpos($useragent, 'Kamelio')) {
            $browser = new KamelioApp($useragent, []);
        } elseif (false !== strpos($useragent, 'FBAV')) {
            $browser = new FacebookApp($useragent, []);
        } elseif (false !== strpos($useragent, 'ACHEETAHI')) {
            $browser = new CmBrowser($useragent, []);
        } elseif (preg_match('/flyflow/i', $useragent)) {
            $browser = new FlyFlow($useragent, []);
        } elseif (false !== strpos($useragent, 'bdbrowser_i18n') || false !== strpos($useragent, 'baidubrowser')) {
            $browser = new BaiduBrowser($useragent, []);
        } elseif (false !== strpos($useragent, 'bdbrowserhd_i18n')) {
            $browser = new BaiduHdBrowser($useragent, []);
        } elseif (false !== strpos($useragent, 'bdbrowser_mini')) {
            $browser = new BaiduMiniBrowser($useragent, []);
        } elseif (false !== strpos($useragent, 'Puffin')) {
            $browser = new Puffin($useragent, []);
        } elseif (preg_match('/stagefright/', $useragent)) {
            $browser = new Stagefright($useragent, []);
        } elseif (false !== strpos($useragent, 'SamsungBrowser')) {
            $browser = new SamsungBrowser($useragent, []);
        } elseif (false !== strpos($useragent, 'Silk')) {
            $browser = new Silk($useragent, []);
        } elseif (false !== strpos($useragent, 'coc_coc_browser')) {
            $browser = new CocCocBrowser($useragent, []);
        } elseif (false !== strpos($useragent, 'NaverMatome')) {
            $browser = new NaverMatome($useragent, []);
        } elseif (preg_match('/FlipboardProxy/', $useragent)) {
            $browser = new FlipboardProxy($useragent, []);
        } elseif (false !== strpos($useragent, 'Flipboard')) {
            $browser = new Flipboard($useragent, []);
        } elseif (false !== strpos($useragent, 'Seznam.cz')) {
            $browser = new SeznamBrowser($useragent, []);
        } elseif (false !== strpos($useragent, 'Aviator')) {
            $browser = new WhiteHatAviator($useragent, []);
        } elseif (preg_match('/NetFrontLifeBrowser/', $useragent)) {
            $browser = new NetFrontLifeBrowser($useragent, []);
        } elseif (preg_match('/IceDragon/', $useragent)) {
            $browser = new ComodoIceDragon($useragent, []);
        } elseif (false !== strpos($useragent, 'Dragon') && false === strpos($useragent, 'DragonFly')) {
            $browser = new ComodoDragon($useragent, []);
        } elseif (false !== strpos($useragent, 'Beamrise')) {
            $browser = new Beamrise($useragent, []);
        } elseif (false !== strpos($useragent, 'Diglo')) {
            $browser = new Diglo($useragent, []);
        } elseif (false !== strpos($useragent, 'APUSBrowser')) {
            $browser = new ApusBrowser($useragent, []);
        } elseif (false !== strpos($useragent, 'Chedot')) {
            $browser = new Chedot($useragent, []);
        } elseif (false !== strpos($useragent, 'Qword')) {
            $browser = new QwordBrowser($useragent, []);
        } elseif (false !== strpos($useragent, 'Iridium')) {
            $browser = new Iridium($useragent, []);
        } elseif (preg_match('/avant/i', $useragent)) {
            $browser = new Avant($useragent, []);
        } elseif (false !== strpos($useragent, 'MxNitro')) {
            $browser = new MaxthonNitro($useragent, []);
        } elseif (preg_match('/(mxbrowser|maxthon|myie)/i', $useragent)) {
            $browser = new Maxthon($useragent, []);
        } elseif (preg_match('/superbird/i', $useragent)) {
            $browser = new SuperBird($useragent, []);
        } elseif (false !== strpos($useragent, 'TinyBrowser')) {
            $browser = new TinyBrowser($useragent, []);
        } elseif (preg_match('/MicroMessenger/', $useragent)) {
            $browser = new WeChatApp($useragent, []);
        } elseif (preg_match('/MQQBrowser\/Mini/', $useragent)) {
            $browser = new QqBrowserMini($useragent, []);
        } elseif (preg_match('/MQQBrowser/', $useragent)) {
            $browser = new QqBrowser($useragent, []);
        } elseif (preg_match('/pinterest/i', $useragent)) {
            $browser = new PinterestApp($useragent, []);
        } elseif (preg_match('/baiduboxapp/', $useragent)) {
            $browser = new BaiduBoxApp($useragent, []);
        } elseif (preg_match('/wkbrowser/', $useragent)) {
            $browser = new WkBrowser($useragent, []);
        } elseif (preg_match('/Mb2345Browser/', $useragent)) {
            $browser = new Browser2345($useragent, []);
        } elseif (false !== strpos($useragent, 'Chrome')
            && false !== strpos($useragent, 'Version')
            && 0 < strpos($useragent, 'Chrome')
        ) {
            $browser = new AndroidWebView($useragent, []);
        } elseif (false !== strpos($useragent, 'Safari')
            && false !== strpos($useragent, 'Version')
            && false !== strpos($useragent, 'Tizen')
        ) {
            $browser = new SamsungWebView($useragent, []);
        } elseif (preg_match('/cybeye/i', $useragent)) {
            $browser = new CybEye($useragent, []);
        } elseif (preg_match('/RebelMouse/', $useragent)) {
            $browser = new RebelMouse($useragent, []);
        } elseif (preg_match('/SeaMonkey/', $useragent)) {
            $browser = new Seamonkey($useragent, []);
        } elseif (preg_match('/Jobboerse/', $useragent)) {
            $browser = new JobBoerseBot($useragent, []);
        } elseif (preg_match('/Navigator/', $useragent)) {
            $browser = new NetscapeNavigator($useragent, []);
        } elseif (preg_match('/firefox/i', $useragent) && preg_match('/anonym/i', $useragent)) {
            $browser = new Firefox($useragent, []);
        } elseif (preg_match('/trident/i', $useragent) && preg_match('/anonym/i', $useragent)) {
            $browser = new MicrosoftInternetExplorer($useragent, []);
        } elseif (preg_match('/Windows\-RSS\-Platform/', $useragent)) {
            $browser = new WindowsRssPlatform($useragent, []);
        } elseif (preg_match('/MarketwireBot/', $useragent)) {
            $browser = new MarketwireBot($useragent, []);
        } elseif (preg_match('/GoogleToolbar/', $useragent)) {
            $browser = new GoogleToolbar($useragent, []);
        } elseif (preg_match('/netscape/i', $useragent) && preg_match('/msie/i', $useragent)) {
            $browser = new Netscape($useragent, []);
        } elseif (preg_match('/LSSRocketCrawler/', $useragent)) {
            $browser = new LightspeedSystemsRocketCrawler($useragent, []);
        } elseif (preg_match('/lightspeedsystems/i', $useragent)) {
            $browser = new LightspeedSystemsCrawler($useragent, []);
        } elseif (preg_match('/SL Commerce Client/', $useragent)) {
            $browser = new SecondLiveCommerceClient($useragent, []);
        } elseif (preg_match('/(IEMobile|WPDesktop|ZuneWP7|XBLWP7)/', $useragent)) {
            $browser = new MicrosoftMobileExplorer($useragent, []);
        } elseif (preg_match('/BingPreview/', $useragent)) {
            $browser = new BingPreview($useragent, []);
        } elseif (preg_match('/360Spider/', $useragent)) {
            $browser = new Bot360($useragent, []);
        } elseif (preg_match('/Outlook\-Express/', $useragent)) {
            $browser = new WindowsLiveMail($useragent, []);
        } elseif (preg_match('/Outlook/', $useragent)) {
            $browser = new MicrosoftOutlook($useragent, []);
        } elseif (preg_match('/microsoft office mobile/i', $useragent)) {
            $browser = new MicrosoftOffice($useragent, []);
        } elseif (preg_match('/MSOffice/', $useragent)) {
            $browser = new MicrosoftOffice($useragent, []);
        } elseif (preg_match('/Microsoft Office Protocol Discovery/', $useragent)) {
            $browser = new MicrosoftOfficeProtocolDiscovery($useragent, []);
        } elseif (preg_match('/excel/i', $useragent)) {
            $browser = new MicrosoftExcel($useragent, []);
        } elseif (preg_match('/powerpoint/i', $useragent)) {
            $browser = new MicrosoftPowerPoint($useragent, []);
        } elseif (preg_match('/WordPress/', $useragent)) {
            $browser = new WordPress($useragent, []);
        } elseif (preg_match('/Word/', $useragent)) {
            $browser = new MicrosoftWord($useragent, []);
        } elseif (preg_match('/OneNote/', $useragent)) {
            $browser = new MicrosoftOneNote($useragent, []);
        } elseif (preg_match('/Visio/', $useragent)) {
            $browser = new MicrosoftVisio($useragent, []);
        } elseif (preg_match('/Access/', $useragent)) {
            $browser = new MicrosoftAccess($useragent, []);
        } elseif (preg_match('/Lync/', $useragent)) {
            $browser = new MicrosoftLync($useragent, []);
        } elseif (preg_match('/Office SyncProc/', $useragent)) {
            $browser = new MicrosoftOfficeSyncProc($useragent, []);
        } elseif (preg_match('/Office Upload Center/', $useragent)) {
            $browser = new MicrosoftOfficeUploadCenter($useragent, []);
        } elseif (preg_match('/frontpage/i', $useragent)) {
            $browser = new MicrosoftFrontPage($useragent, []);
        } elseif (preg_match('/microsoft office/i', $useragent)) {
            $browser = new MicrosoftOffice($useragent, []);
        } elseif (preg_match('/Crazy Browser/', $useragent)) {
            $browser = new CrazyBrowser($useragent, []);
        } elseif (preg_match('/Deepnet Explorer/', $useragent)) {
            $browser = new DeepnetExplorer($useragent, []);
        } elseif (preg_match('/kkman/i', $useragent)) {
            $browser = new Kkman($useragent, []);
        } elseif (preg_match('/Lunascape/', $useragent)) {
            $browser = new Lunascape($useragent, []);
        } elseif (preg_match('/Sleipnir/', $useragent)) {
            $browser = new Sleipnir($useragent, []);
        } elseif (preg_match('/Smartsite HTTPClient/', $useragent)) {
            $browser = new SmartsiteHttpClient($useragent, []);
        } elseif (preg_match('/GomezAgent/', $useragent)) {
            $browser = new GomezSiteMonitor($useragent, []);
        } elseif (preg_match('/Mozilla\/5\.0.*\(.*Trident\/8\.0.*rv\:\d+\).*/', $useragent)
            || preg_match('/Mozilla\/5\.0.*\(.*Trident\/7\.0.*\) like Gecko.*/', $useragent)
            || preg_match('/Mozilla\/5\.0.*\(.*MSIE 10\.0.*Trident\/(4|5|6|7|8)\.0.*/', $useragent)
            || preg_match('/Mozilla\/(4|5)\.0.*\(.*MSIE (9|8|7|6)\.0.*/', $useragent)
            || preg_match('/Mozilla\/(4|5)\.0.*\(.*MSIE (5|4)\.\d+.*/', $useragent)
            || preg_match('/Mozilla\/\d\.\d+.*\(.*MSIE (3|2|1)\.\d+.*/', $useragent)
        ) {
            $browser = new MicrosoftInternetExplorer($useragent, []);
        } elseif (false !== strpos($useragent, 'Chromium')) {
            $browser = new Chromium($useragent, []);
        } elseif (false !== strpos($useragent, 'Iron')) {
            $browser = new Iron($useragent, []);
        } elseif (preg_match('/midori/i', $useragent)) {
            $browser = new Midori($useragent, []);
        } elseif (preg_match('/Google Page Speed Insights/', $useragent)) {
            $browser = new GooglePageSpeedInsights($useragent, []);
        } elseif (preg_match('/(web\/snippet)/', $useragent)) {
            $browser = new GoogleWebSnippet($useragent, []);
        } elseif (preg_match('/(googlebot\-mobile)/i', $useragent)) {
            $browser = new GooglebotMobileBot($useragent, []);
        } elseif (preg_match('/Google Wireless Transcoder/', $useragent)) {
            $browser = new GoogleWirelessTranscoder($useragent, []);
        } elseif (preg_match('/Locubot/', $useragent)) {
            $browser = new Locubot($useragent, []);
        } elseif (preg_match('/(com\.google\.GooglePlus)/i', $useragent)) {
            $browser = new GooglePlus($useragent, []);
        } elseif (preg_match('/Google\-HTTP\-Java\-Client/', $useragent)) {
            $browser = new GoogleHttpClientLibraryForJava($useragent, []);
        } elseif (preg_match('/acapbot/i', $useragent)) {
            $browser = new Acapbot($useragent, []);
        } elseif (preg_match('/googlebot\-image/i', $useragent)) {
            $browser = new GoogleImageSearch($useragent, []);
        } elseif (preg_match('/googlebot/i', $useragent)) {
            $browser = new Googlebot($useragent, []);
        } elseif (preg_match('/^GOOG$/', $useragent)) {
            $browser = new Googlebot($useragent, []);
        } elseif (preg_match('/viera/i', $useragent)) {
            $browser = new SmartViera($useragent, []);
        } elseif (preg_match('/Nichrome/', $useragent)) {
            $browser = new Nichrome($useragent, []);
        } elseif (preg_match('/Kinza/', $useragent)) {
            $browser = new Kinza($useragent, []);
        } elseif (preg_match('/Google Keyword Suggestion/', $useragent)) {
            $browser = new GoogleKeywordSuggestion($useragent, []);
        } elseif (preg_match('/Google Web Preview/', $useragent)) {
            $browser = new GoogleWebPreview($useragent, []);
        } elseif (preg_match('/Google-Adwords-DisplayAds-WebRender/', $useragent)) {
            $browser = new GoogleAdwordsDisplayAdsWebRender($useragent, []);
        } elseif (preg_match('/HubSpot Webcrawler/', $useragent)) {
            $browser = new HubSpotWebcrawler($useragent, []);
        } elseif (preg_match('/RockMelt/', $useragent)) {
            $browser = new Rockmelt($useragent, []);
        } elseif (preg_match('/ SE /', $useragent)) {
            $browser = new SogouExplorer($useragent, []);
        } elseif (preg_match('/ArchiveBot/', $useragent)) {
            $browser = new ArchiveBot($useragent, []);
        } elseif (preg_match('/Edge/', $useragent) && null !== $platform && 'Windows Phone OS' === $platform->getName()) {
            $browser = new MicrosoftEdgeMobile($useragent, []);
        } elseif (preg_match('/Edge/', $useragent)) {
            $browser = new MicrosoftEdge($useragent, []);
        } elseif (preg_match('/diffbot/i', $useragent)) {
            $browser = new Diffbot($useragent, []);
        } elseif (preg_match('/vivaldi/i', $useragent)) {
            $browser = new Vivaldi($useragent, []);
        } elseif (preg_match('/LBBROWSER/', $useragent)) {
            $browser = new Liebao($useragent, []);
        } elseif (preg_match('/Amigo/', $useragent)) {
            $browser = new Amigo($useragent, []);
        } elseif (preg_match('/CoolNovoChromePlus/', $useragent)) {
            $browser = new CoolNovoChromePlus($useragent, []);
        } elseif (preg_match('/CoolNovo/', $useragent)) {
            $browser = new CoolNovo($useragent, []);
        } elseif (preg_match('/Kenshoo/', $useragent)) {
            $browser = new Kenshoo($useragent, []);
        } elseif (preg_match('/Bowser/', $useragent)) {
            $browser = new Bowser($useragent, []);
        } elseif (preg_match('/360SE/', $useragent)) {
            $browser = new SecureBrowser360($useragent, []);
        } elseif (preg_match('/360EE/', $useragent)) {
            $browser = new SpeedBrowser360($useragent, []);
        } elseif (preg_match('/ASW/', $useragent)) {
            $browser = new AvastSafeZone($useragent, []);
        } elseif (preg_match('/Wire/', $useragent)) {
            $browser = new WireApp($useragent, []);
        } elseif (preg_match('/chrome\/(\d+)\.(\d+)/i', $useragent, $matches)
            && isset($matches[1])
            && isset($matches[2])
            && $matches[1] >= 1
            && $matches[2] > 0
            && $matches[2] <= 10
        ) {
            $browser = new ComodoDragon($useragent, []);
        } elseif (preg_match('/Flock/', $useragent)) {
            $browser = new Flock($useragent, []);
        } elseif (preg_match('/Bromium Safari/', $useragent)) {
            $browser = new Vsentry($useragent, []);
        } elseif (preg_match('/(chrome|crmo|crios)/i', $useragent)) {
            $browser = new Chrome($useragent, []);
        } elseif (preg_match('/(dolphin http client)/i', $useragent)) {
            $browser = new DolphinSmalltalkHttpClient($useragent, []);
        } elseif (preg_match('/(dolphin|dolfin)/i', $useragent)) {
            $browser = new Dolfin($useragent, []);
        } elseif (preg_match('/Arora/', $useragent)) {
            $browser = new Arora($useragent, []);
        } elseif (preg_match('/com\.douban\.group/i', $useragent)) {
            $browser = new DoubanApp($useragent, []);
        } elseif (preg_match('/ovibrowser/i', $useragent)) {
            $browser = new NokiaProxyBrowser($useragent, []);
        } elseif (preg_match('/MiuiBrowser/i', $useragent)) {
            $browser = new MiuiBrowser($useragent, []);
        } elseif (preg_match('/ibrowser/i', $useragent)) {
            $browser = new IBrowser($useragent, []);
        } elseif (preg_match('/OneBrowser/', $useragent)) {
            $browser = new OneBrowser($useragent, []);
        } elseif (preg_match('/Baiduspider\-image/', $useragent)) {
            $browser = new BaiduImageSearch($useragent, []);
        } elseif (preg_match('/http:\/\/www\.baidu\.com\/search/', $useragent)) {
            $browser = new BaiduMobileSearch($useragent, []);
        } elseif (preg_match('/(yjapp|yjtop)/i', $useragent)) {
            $browser = new YahooApp($useragent, []);
        } elseif (preg_match('/(linux; u; android|linux; android)/i', $useragent) && preg_match('/version/i', $useragent)) {
            $browser = new AndroidWebkit($useragent, []);
        } elseif (preg_match('/safari/i', $useragent) && null !== $platform && 'Android' === $platform->getName()) {
            $browser = new AndroidWebkit($useragent, []);
        } elseif (preg_match('/Browser\/AppleWebKit/', $useragent)) {
            $browser = new AndroidWebkit($useragent, []);
        } elseif (preg_match('/Android\/[\d\.]+ release/', $useragent)) {
            $browser = new AndroidWebkit($useragent, []);
        } elseif (false !== strpos($useragent, 'BlackBerry') && false !== strpos($useragent, 'Version')) {
            $browser = new Blackberry($useragent, []);
        } elseif (preg_match('/(webOS|wOSBrowser|wOSSystem)/', $useragent)) {
            $browser = new WebkitWebos($useragent, []);
        } elseif (preg_match('/OmniWeb/', $useragent)) {
            $browser = new Omniweb($useragent, []);
        } elseif (preg_match('/Windows Phone Search/', $useragent)) {
            $browser = new WindowsPhoneSearch($useragent, []);
        } elseif (preg_match('/Windows\-Update\-Agent/', $useragent)) {
            $browser = new WindowsUpdateAgent($useragent, []);
        } elseif (preg_match('/nokia/i', $useragent)) {
            $browser = new NokiaBrowser($useragent, []);
        } elseif (preg_match('/twitter for i/i', $useragent)) {
            $browser = new TwitterApp($useragent, []);
        } elseif (preg_match('/twitterbot/i', $useragent)) {
            $browser = new Twitterbot($useragent, []);
        } elseif (preg_match('/GSA/', $useragent)) {
            $browser = new GoogleApp($useragent, []);
        } elseif (preg_match('/QtCarBrowser/', $useragent)) {
            $browser = new ModelsBrowser($useragent, []);
        } elseif (preg_match('/Qt/', $useragent)) {
            $browser = new Qt($useragent, []);
        } elseif (preg_match('/Instagram/', $useragent)) {
            $browser = new InstagramApp($useragent, []);
        } elseif (preg_match('/WebClip/', $useragent)) {
            $browser = new WebClip($useragent, []);
        } elseif (preg_match('/Mercury/', $useragent)) {
            $browser = new Mercury($useragent, []);
        } elseif (preg_match('/MacAppStore/', $useragent)) {
            $browser = new MacAppStore($useragent, []);
        } elseif (preg_match('/AppStore/', $useragent)) {
            $browser = new AppleAppStoreApp($useragent, []);
        } elseif (preg_match('/Webglance/', $useragent)) {
            $browser = new WebGlance($useragent, []);
        } elseif (preg_match('/YHOO\_Search\_App/', $useragent)) {
            $browser = new YahooMobileApp($useragent, []);
        } elseif (preg_match('/NewsBlur Feed Fetcher/', $useragent)) {
            $browser = new NewsBlurFeedFetcher($useragent, []);
        } elseif (preg_match('/AppleCoreMedia/', $useragent)) {
            $browser = new AppleCoreMedia($useragent, []);
        } elseif (preg_match('/dataaccessd/', $useragent)) {
            $browser = new IosDataaccessd($useragent, []);
        } elseif (preg_match('/MailChimp/', $useragent)) {
            $browser = new MailChimp($useragent, []);
        } elseif (preg_match('/MailBar/', $useragent)) {
            $browser = new MailBar($useragent, []);
        } elseif (preg_match('/^Mail/', $useragent)) {
            $browser = new AppleMail($useragent, []);
        } elseif (preg_match('/^Mozilla\/5\.0.*\(.*(CPU iPhone OS|CPU OS) \d+(_|\.)\d+.* like Mac OS X.*\) AppleWebKit.* \(KHTML, like Gecko\)$/', $useragent)) {
            $browser = new AppleMail($useragent, []);
        } elseif (preg_match('/^Mozilla\/5\.0 \(Macintosh; Intel Mac OS X.*\) AppleWebKit.* \(KHTML, like Gecko\)$/', $useragent)) {
            $browser = new AppleMail($useragent, []);
        } elseif (preg_match('/^Mozilla\/5\.0 \(Windows.*\) AppleWebKit.* \(KHTML, like Gecko\)$/', $useragent)) {
            $browser = new AppleMail($useragent, []);
        } elseif (preg_match('/msnbot\-media/i', $useragent)) {
            $browser = new MsnBotMedia($useragent, []);
        } elseif (preg_match('/adidxbot/i', $useragent)) {
            $browser = new Adidxbot($useragent, []);
        } elseif (preg_match('/msnbot/i', $useragent)) {
            $browser = new Bingbot($useragent, []);
        } elseif (preg_match('/(backberry|bb10)/i', $useragent)) {
            $browser = new Blackberry($useragent, []);
        } elseif (preg_match('/WeTab\-Browser/', $useragent)) {
            $browser = new WeTabBrowser($useragent, []);
        } elseif (preg_match('/profiller/', $useragent)) {
            $browser = new Profiller($useragent, []);
        } elseif (preg_match('/(wkhtmltopdf)/i', $useragent)) {
            $browser = new WkHtmltopdf($useragent, []);
        } elseif (preg_match('/(wkhtmltoimage)/i', $useragent)) {
            $browser = new WkHtmltoImage($useragent, []);
        } elseif (preg_match('/(wp\-iphone|wp\-android)/', $useragent)) {
            $browser = new WordPressApp($useragent, []);
        } elseif (preg_match('/OktaMobile/', $useragent)) {
            $browser = new OktaMobileApp($useragent, []);
        } elseif (preg_match('/kmail2/', $useragent)) {
            $browser = new Kmail2($useragent, []);
        } elseif (preg_match('/eb\-iphone/', $useragent)) {
            $browser = new EbApp($useragent, []);
        } elseif (preg_match('/ElmediaPlayer/', $useragent)) {
            $browser = new ElmediaPlayer($useragent, []);
        } elseif (preg_match('/Schoolwires/', $useragent)) {
            $browser = new SchoolwiresApp($useragent, []);
        } elseif (preg_match('/Dreamweaver/', $useragent)) {
            $browser = new Dreamweaver($useragent, []);
        } elseif (preg_match('/akregator/', $useragent)) {
            $browser = new Akregator($useragent, []);
        } elseif (preg_match('/Installatron/', $useragent)) {
            $browser = new Installatron($useragent, []);
        } elseif (preg_match('/Quora Link Preview/', $useragent)) {
            $browser = new QuoraLinkPreviewBot($useragent, []);
        } elseif (preg_match('/Quora/', $useragent)) {
            $browser = new QuoraApp($useragent, []);
        } elseif (preg_match('/Rocky ChatWork Mobile/', $useragent)) {
            $browser = new RockyChatWorkMobile($useragent, []);
        } elseif (preg_match('/AdsBot\-Google\-Mobile/', $useragent)) {
            $browser = new GoogleAdsbotMobile($useragent, []);
        } elseif (preg_match('/epiphany/i', $useragent)) {
            $browser = new Epiphany($useragent, []);
        } elseif (preg_match('/rekonq/', $useragent)) {
            $browser = new Rekonq($useragent, []);
        } elseif (preg_match('/Skyfire/', $useragent)) {
            $browser = new Skyfire($useragent, []);
        } elseif (preg_match('/FlixsteriOS/', $useragent)) {
            $browser = new FlixsterApp($useragent, []);
        } elseif (preg_match('/(adbeat\_bot|adbeat\.com)/', $useragent)) {
            $browser = new AdbeatBot($useragent, []);
        } elseif (preg_match('/(SecondLife|Second Life)/', $useragent)) {
            $browser = new SecondLiveClient($useragent, []);
        } elseif (preg_match('/(Salesforce1|SalesforceTouchContainer)/', $useragent)) {
            $browser = new SalesForceApp($useragent, []);
        } elseif (preg_match('/(nagios\-plugins|check\_http)/', $useragent)) {
            $browser = new Nagios($useragent, []);
        } elseif (preg_match('/bingbot/i', $useragent)) {
            $browser = new Bingbot($useragent, []);
        } elseif (preg_match('/Mediapartners\-Google/', $useragent)) {
            $browser = new GoogleAdSenseBot($useragent, []);
        } elseif (preg_match('/SMTBot/', $useragent)) {
            $browser = new SmtBot($useragent, []);
        } elseif (preg_match('/domain\.com/', $useragent)) {
            $browser = new PagePeekerScreenshotMaker($useragent, []);
        } elseif (preg_match('/PagePeeker/', $useragent)) {
            $browser = new PagePeeker($useragent, []);
        } elseif (preg_match('/DiigoBrowser/', $useragent)) {
            $browser = new DiigoBrowser($useragent, []);
        } elseif (preg_match('/kontact/', $useragent)) {
            $browser = new Kontact($useragent, []);
        } elseif (preg_match('/QupZilla/', $useragent)) {
            $browser = new QupZilla($useragent, []);
        } elseif (preg_match('/FxiOS/', $useragent)) {
            $browser = new FirefoxIos($useragent, []);
        } elseif (preg_match('/qutebrowser/', $useragent)) {
            $browser = new QuteBrowser($useragent, []);
        } elseif (preg_match('/Otter/', $useragent)) {
            $browser = new Otter($useragent, []);
        } elseif (preg_match('/PaleMoon/', $useragent)) {
            $browser = new Palemoon($useragent, []);
        } elseif (preg_match('/slurp/i', $useragent)) {
            $browser = new YahooSlurp($useragent, []);
        } elseif (preg_match('/applebot/i', $useragent)) {
            $browser = new Applebot($useragent, []);
        } elseif (preg_match('/SoundCloud/', $useragent)) {
            $browser = new SoundCloudApp($useragent, []);
        } elseif (preg_match('/Rival IQ/', $useragent)) {
            $browser = new RivalIqBot($useragent, []);
        } elseif (preg_match('/Evernote Clip Resolver/', $useragent)) {
            $browser = new EvernoteClipResolver($useragent, []);
        } elseif (preg_match('/Evernote/', $useragent)) {
            $browser = new EvernoteApp($useragent, []);
        } elseif (preg_match('/Fluid/', $useragent)) {
            $browser = new Fluid($useragent, []);
        } elseif (preg_match('/safari/i', $useragent)) {
            $browser = new Safari($useragent, []);
        } elseif (preg_match('/^Mozilla\/(4|5)\.0 \(Macintosh; .* Mac OS X .*\) AppleWebKit\/.* \(KHTML, like Gecko\) Version\/[\d\.]+$/i', $useragent)) {
            $browser = new Safari($useragent, []);
        } elseif (preg_match('/TWCAN\/SportsNet/', $useragent)) {
            $browser = new TwcSportsNet($useragent, []);
        } elseif (preg_match('/AdobeAIR/', $useragent)) {
            $browser = new AdobeAIR($useragent, []);
        } elseif (preg_match('/(easouspider)/i', $useragent)) {
            $browser = new EasouSpider($useragent, []);
        } elseif (preg_match('/^Mozilla\/5\.0.*\((iPhone|iPad|iPod).*\).*AppleWebKit\/.*\(.*KHTML, like Gecko.*\).*Mobile.*/i', $useragent)) {
            $browser = new MobileSafariUiWebView($useragent, []);
        } elseif (preg_match('/waterfox/i', $useragent)) {
            $browser = new WaterFox($useragent, []);
        } elseif (preg_match('/Thunderbird/', $useragent)) {
            $browser = new Thunderbird($useragent, []);
        } elseif (preg_match('/Fennec/', $useragent)) {
            $browser = new Fennec($useragent, []);
        } elseif (preg_match('/myibrow/', $useragent)) {
            $browser = new MyInternetBrowser($useragent, []);
        } elseif (preg_match('/Daumoa/', $useragent)) {
            $browser = new Daumoa($useragent, []);
        } elseif (preg_match('/PaleMoon/', $useragent)) {
            $browser = new Palemoon($useragent, []);
        } elseif (preg_match('/iceweasel/i', $useragent)) {
            $browser = new Iceweasel($useragent, []);
        } elseif (preg_match('/icecat/i', $useragent)) {
            $browser = new IceCat($useragent, []);
        } elseif (preg_match('/iceape/i', $useragent)) {
            $browser = new Iceape($useragent, []);
        } elseif (preg_match('/galeon/i', $useragent)) {
            $browser = new Galeon($useragent, []);
        } elseif (preg_match('/SurveyBot/', $useragent)) {
            $browser = new SurveyBot($useragent, []);
        } elseif (preg_match('/aggregator\:Spinn3r/', $useragent)) {
            $browser = new Spinn3rRssAggregator($useragent, []);
        } elseif (preg_match('/TweetmemeBot/', $useragent)) {
            $browser = new TweetmemeBot($useragent, []);
        } elseif (preg_match('/Butterfly/', $useragent)) {
            $browser = new ButterflyRobot($useragent, []);
        } elseif (preg_match('/James BOT/', $useragent)) {
            $browser = new JamesBot($useragent, []);
        } elseif (preg_match('/MSIE or Firefox mutant; not on Windows server/', $useragent)) {
            $browser = new Daumoa($useragent, []);
        } elseif (preg_match('/SailfishBrowser/', $useragent)) {
            $browser = new SailfishBrowser($useragent, []);
        } elseif (preg_match('/KcB/', $useragent)) {
            $browser = new UnknownBrowser($useragent, []);
        } elseif (preg_match('/kazehakase/i', $useragent)) {
            $browser = new Kazehakase($useragent, []);
        } elseif (preg_match('/cometbird/i', $useragent)) {
            $browser = new CometBird($useragent, []);
        } elseif (preg_match('/Camino/', $useragent)) {
            $browser = new Camino($useragent, []);
        } elseif (preg_match('/SlimerJS/', $useragent)) {
            $browser = new SlimerJs($useragent, []);
        } elseif (preg_match('/MultiZilla/', $useragent)) {
            $browser = new MultiZilla($useragent, []);
        } elseif (preg_match('/Minimo/', $useragent)) {
            $browser = new Minimo($useragent, []);
        } elseif (preg_match('/MicroB/', $useragent)) {
            $browser = new MicroB($useragent, []);
        } elseif (preg_match('/firefox/i', $useragent)
            && !preg_match('/gecko/i', $useragent)
            && preg_match('/anonymized/i', $useragent)
        ) {
            $browser = new Firefox($useragent, []);
        } elseif (preg_match('/(firefox|minefield|shiretoko|bonecho|namoroka)/i', $useragent)) {
            $browser = new Firefox($useragent, []);
        } elseif (preg_match('/gvfs/', $useragent)) {
            $browser = new Gvfs($useragent, []);
        } elseif (preg_match('/luakit/', $useragent)) {
            $browser = new Luakit($useragent, []);
        } elseif (preg_match('/playstation 3/i', $useragent)) {
            $browser = new NetFront($useragent, []);
        } elseif (preg_match('/sistrix/i', $useragent)) {
            $browser = new Sistrix($useragent, []);
        } elseif (preg_match('/ezooms/i', $useragent)) {
            $browser = new Ezooms($useragent, []);
        } elseif (preg_match('/grapefx/i', $useragent)) {
            $browser = new GrapeFx($useragent, []);
        } elseif (preg_match('/grapeshotcrawler/i', $useragent)) {
            $browser = new GrapeshotCrawler($useragent, []);
        } elseif (preg_match('/(mail\.ru)/i', $useragent)) {
            $browser = new MailRu($useragent, []);
        } elseif (preg_match('/(proximic)/i', $useragent)) {
            $browser = new Proximic($useragent, []);
        } elseif (preg_match('/(polaris)/i', $useragent)) {
            $browser = new Polaris($useragent, []);
        } elseif (preg_match('/(another web mining tool|awmt)/i', $useragent)) {
            $browser = new AnotherWebMiningTool($useragent, []);
        } elseif (preg_match('/(wbsearchbot|wbsrch)/i', $useragent)) {
            $browser = new WbSearchBot($useragent, []);
        } elseif (preg_match('/(konqueror)/i', $useragent)) {
            $browser = new Konqueror($useragent, []);
        } elseif (preg_match('/(typo3\-linkvalidator)/i', $useragent)) {
            $browser = new Typo3Linkvalidator($useragent, []);
        } elseif (preg_match('/feeddlerrss/i', $useragent)) {
            $browser = new FeeddlerRssReader($useragent, []);
        } elseif (preg_match('/^mozilla\/5\.0 \((iphone|ipad|ipod).*CPU like Mac OS X.*\) AppleWebKit\/\d+/i', $useragent)) {
            $browser = new Safari($useragent, []);
        } elseif (preg_match('/(ios|iphone|ipad|ipod)/i', $useragent)) {
            $browser = new MobileSafariUiWebView($useragent, []);
        } elseif (preg_match('/paperlibot/i', $useragent)) {
            $browser = new PaperLiBot($useragent, []);
        } elseif (preg_match('/spbot/i', $useragent)) {
            $browser = new Seoprofiler($useragent, []);
        } elseif (preg_match('/dotbot/i', $useragent)) {
            $browser = new DotBot($useragent, []);
        } elseif (preg_match('/(google\-structureddatatestingtool|Google\-structured\-data\-testing\-tool)/i', $useragent)) {
            $browser = new GoogleStructuredDataTestingTool($useragent, []);
        } elseif (preg_match('/webmastercoffee/i', $useragent)) {
            $browser = new WebmasterCoffee($useragent, []);
        } elseif (preg_match('/ahrefs/i', $useragent)) {
            $browser = new AhrefsBot($useragent, []);
        } elseif (preg_match('/apercite/i', $useragent)) {
            $browser = new Apercite($useragent, []);
        } elseif (preg_match('/woobot/', $useragent)) {
            $browser = new WooRank($useragent, []);
        } elseif (preg_match('/Blekkobot/', $useragent)) {
            $browser = new BlekkoBot($useragent, []);
        } elseif (preg_match('/PagesInventory/', $useragent)) {
            $browser = new PagesInventoryBot($useragent, []);
        } elseif (preg_match('/Slackbot\-LinkExpanding/', $useragent)) {
            $browser = new SlackbotLinkExpanding($useragent, []);
        } elseif (preg_match('/Slackbot/', $useragent)) {
            $browser = new Slackbot($useragent, []);
        } elseif (preg_match('/SEOkicks\-Robot/', $useragent)) {
            $browser = new Seokicks($useragent, []);
        } elseif (preg_match('/Exabot/', $useragent)) {
            $browser = new Exabot($useragent, []);
        } elseif (preg_match('/DomainSCAN/', $useragent)) {
            $browser = new DomainScanServerMonitoring($useragent, []);
        } elseif (preg_match('/JobRoboter/', $useragent)) {
            $browser = new JobRoboter($useragent, []);
        } elseif (preg_match('/AcoonBot/', $useragent)) {
            $browser = new AcoonBot($useragent, []);
        } elseif (preg_match('/woriobot/', $useragent)) {
            $browser = new Woriobot($useragent, []);
        } elseif (preg_match('/MonoBot/', $useragent)) {
            $browser = new MonoBot($useragent, []);
        } elseif (preg_match('/DomainSigmaCrawler/', $useragent)) {
            $browser = new DomainSigmaCrawler($useragent, []);
        } elseif (preg_match('/bnf\.fr\_bot/', $useragent)) {
            $browser = new BnfFrBot($useragent, []);
        } elseif (preg_match('/CrawlRobot/', $useragent)) {
            $browser = new CrawlRobot($useragent, []);
        } elseif (preg_match('/AddThis\.com robot/', $useragent)) {
            $browser = new AddThisRobot($useragent, []);
        } elseif (preg_match('/(Yeti|naver\.com\/robots)/', $useragent)) {
            $browser = new NaverBot($useragent, []);
        } elseif (preg_match('/^robots$/', $useragent)) {
            $browser = new TestCrawler($useragent, []);
        } elseif (preg_match('/DeuSu/', $useragent)) {
            $browser = new WerbefreieDeutscheSuchmaschine($useragent, []);
        } elseif (preg_match('/obot/i', $useragent)) {
            $browser = new Obot($useragent, []);
        } elseif (preg_match('/ZumBot/', $useragent)) {
            $browser = new ZumBot($useragent, []);
        } elseif (preg_match('/(umbot)/i', $useragent)) {
            $browser = new UmBot($useragent, []);
        } elseif (preg_match('/(picmole)/i', $useragent)) {
            $browser = new PicmoleBot($useragent, []);
        } elseif (preg_match('/(zollard)/i', $useragent)) {
            $browser = new ZollardWorm($useragent, []);
        } elseif (preg_match('/(fhscan core)/i', $useragent)) {
            $browser = new FhscanCore($useragent, []);
        } elseif (preg_match('/nbot/i', $useragent)) {
            $browser = new Nbot($useragent, []);
        } elseif (preg_match('/(loadtimebot)/i', $useragent)) {
            $browser = new LoadTimeBot($useragent, []);
        } elseif (preg_match('/(scrubby)/i', $useragent)) {
            $browser = new Scrubby($useragent, []);
        } elseif (preg_match('/(squzer)/i', $useragent)) {
            $browser = new Squzer($useragent, []);
        } elseif (preg_match('/PiplBot/', $useragent)) {
            $browser = new PiplBot($useragent, []);
        } elseif (preg_match('/EveryoneSocialBot/', $useragent)) {
            $browser = new EveryoneSocialBot($useragent, []);
        } elseif (preg_match('/AOLbot/', $useragent)) {
            $browser = new AolBot($useragent, []);
        } elseif (preg_match('/GLBot/', $useragent)) {
            $browser = new GlBot($useragent, []);
        } elseif (preg_match('/(lbot)/i', $useragent)) {
            $browser = new Lbot($useragent, []);
        } elseif (preg_match('/(blexbot)/i', $useragent)) {
            $browser = new BlexBot($useragent, []);
        } elseif (preg_match('/(socialradarbot)/i', $useragent)) {
            $browser = new Socialradarbot($useragent, []);
        } elseif (preg_match('/(synapse)/i', $useragent)) {
            $browser = new ApacheSynapse($useragent, []);
        } elseif (preg_match('/(linkdexbot)/i', $useragent)) {
            $browser = new LinkdexBot($useragent, []);
        } elseif (preg_match('/(coccoc)/i', $useragent)) {
            $browser = new CocCocBot($useragent, []);
        } elseif (preg_match('/(siteexplorer)/i', $useragent)) {
            $browser = new SiteExplorer($useragent, []);
        } elseif (preg_match('/(semrushbot)/i', $useragent)) {
            $browser = new SemrushBot($useragent, []);
        } elseif (preg_match('/(istellabot)/i', $useragent)) {
            $browser = new IstellaBot($useragent, []);
        } elseif (preg_match('/(meanpathbot)/i', $useragent)) {
            $browser = new MeanpathBot($useragent, []);
        } elseif (preg_match('/(XML Sitemaps Generator)/', $useragent)) {
            $browser = new XmlSitemapsGenerator($useragent, []);
        } elseif (preg_match('/SeznamBot/', $useragent)) {
            $browser = new SeznamBot($useragent, []);
        } elseif (preg_match('/URLAppendBot/', $useragent)) {
            $browser = new UrlAppendBot($useragent, []);
        } elseif (preg_match('/NetSeer crawler/', $useragent)) {
            $browser = new NetseerCrawler($useragent, []);
        } elseif (preg_match('/SeznamBot/', $useragent)) {
            $browser = new SeznamBot($useragent, []);
        } elseif (preg_match('/Add Catalog/', $useragent)) {
            $browser = new AddCatalog($useragent, []);
        } elseif (preg_match('/Moreover/', $useragent)) {
            $browser = new Moreover($useragent, []);
        } elseif (preg_match('/LinkpadBot/', $useragent)) {
            $browser = new LinkpadBot($useragent, []);
        } elseif (preg_match('/Lipperhey SEO Service/', $useragent)) {
            $browser = new LipperheySeoService($useragent, []);
        } elseif (preg_match('/Blog Search/', $useragent)) {
            $browser = new BlogSearch($useragent, []);
        } elseif (preg_match('/Qualidator\.com Bot/', $useragent)) {
            $browser = new QualidatorBot($useragent, []);
        } elseif (preg_match('/fr\-crawler/', $useragent)) {
            $browser = new FrCrawler($useragent, []);
        } elseif (preg_match('/ca\-crawler/', $useragent)) {
            $browser = new CaCrawler($useragent, []);
        } elseif (preg_match('/Website Thumbnail Generator/', $useragent)) {
            $browser = new WebsiteThumbnailGenerator($useragent, []);
        } elseif (preg_match('/WebThumb/', $useragent)) {
            $browser = new WebThumb($useragent, []);
        } elseif (preg_match('/KomodiaBot/', $useragent)) {
            $browser = new KomodiaBot($useragent, []);
        } elseif (preg_match('/GroupHigh/', $useragent)) {
            $browser = new GroupHighBot($useragent, []);
        } elseif (preg_match('/theoldreader/', $useragent)) {
            $browser = new TheOldReader($useragent, []);
        } elseif (preg_match('/Google\-Site\-Verification/', $useragent)) {
            $browser = new GoogleSiteVerification($useragent, []);
        } elseif (preg_match('/Prlog/', $useragent)) {
            $browser = new Prlog($useragent, []);
        } elseif (preg_match('/CMS Crawler/', $useragent)) {
            $browser = new CmsCrawler($useragent, []);
        } elseif (preg_match('/pmoz\.info ODP link checker/', $useragent)) {
            $browser = new PmozinfoOdpLinkChecker($useragent, []);
        } elseif (preg_match('/Twingly Recon/', $useragent)) {
            $browser = new TwinglyRecon($useragent, []);
        } elseif (preg_match('/Embedly/', $useragent)) {
            $browser = new Embedly($useragent, []);
        } elseif (preg_match('/Alexabot/', $useragent)) {
            $browser = new Alexabot($useragent, []);
        } elseif (preg_match('/alexa site audit/', $useragent)) {
            $browser = new AlexaSiteAudit($useragent, []);
        } elseif (preg_match('/MJ12bot/', $useragent)) {
            $browser = new Mj12bot($useragent, []);
        } elseif (preg_match('/HTTrack/', $useragent)) {
            $browser = new Httrack($useragent, []);
        } elseif (preg_match('/UnisterBot/', $useragent)) {
            $browser = new Unisterbot($useragent, []);
        } elseif (preg_match('/CareerBot/', $useragent)) {
            $browser = new CareerBot($useragent, []);
        } elseif (preg_match('/80legs/i', $useragent)) {
            $browser = new Bot80Legs($useragent, []);
        } elseif (preg_match('/wada\.vn/i', $useragent)) {
            $browser = new WadavnSearchBot($useragent, []);
        } elseif (preg_match('/(NX|WiiU|Nintendo 3DS)/', $useragent)) {
            $browser = new NetFrontNx($useragent, []);
        } elseif (preg_match('/(netfront|playstation 4)/i', $useragent)) {
            $browser = new NetFront($useragent, []);
        } elseif (preg_match('/XoviBot/', $useragent)) {
            $browser = new XoviBot($useragent, []);
        } elseif (preg_match('/007ac9 Crawler/', $useragent)) {
            $browser = new Crawler007AC9($useragent, []);
        } elseif (preg_match('/200PleaseBot/', $useragent)) {
            $browser = new Please200Bot($useragent, []);
        } elseif (preg_match('/Abonti/', $useragent)) {
            $browser = new AbontiBot($useragent, []);
        } elseif (preg_match('/publiclibraryarchive/', $useragent)) {
            $browser = new PublicLibraryArchive($useragent, []);
        } elseif (preg_match('/PAD\-bot/', $useragent)) {
            $browser = new PadBot($useragent, []);
        } elseif (preg_match('/SoftListBot/', $useragent)) {
            $browser = new SoftListBot($useragent, []);
        } elseif (preg_match('/sReleaseBot/', $useragent)) {
            $browser = new SreleaseBot($useragent, []);
        } elseif (preg_match('/Vagabondo/', $useragent)) {
            $browser = new Vagabondo($useragent, []);
        } elseif (preg_match('/special\_archiver/', $useragent)) {
            $browser = new InternetArchiveSpecialArchiver($useragent, []);
        } elseif (preg_match('/Optimizer/', $useragent)) {
            $browser = new OptimizerBot($useragent, []);
        } elseif (preg_match('/Sophora Linkchecker/', $useragent)) {
            $browser = new SophoraLinkchecker($useragent, []);
        } elseif (preg_match('/SEOdiver/', $useragent)) {
            $browser = new SeoDiver($useragent, []);
        } elseif (preg_match('/itsscan/', $useragent)) {
            $browser = new ItsScan($useragent, []);
        } elseif (preg_match('/Google Desktop/', $useragent)) {
            $browser = new GoogleDesktop($useragent, []);
        } elseif (preg_match('/Lotus\-Notes/', $useragent)) {
            $browser = new LotusNotes($useragent, []);
        } elseif (preg_match('/AskPeterBot/', $useragent)) {
            $browser = new AskPeterBot($useragent, []);
        } elseif (preg_match('/discoverybot/', $useragent)) {
            $browser = new DiscoveryBot($useragent, []);
        } elseif (preg_match('/YandexBot/', $useragent)) {
            $browser = new YandexBot($useragent, []);
        } elseif (preg_match('/MOSBookmarks/', $useragent) && preg_match('/Link Checker/', $useragent)) {
            $browser = new MosBookmarksLinkChecker($useragent, []);
        } elseif (preg_match('/MOSBookmarks/', $useragent)) {
            $browser = new MosBookmarks($useragent, []);
        } elseif (preg_match('/WebMasterAid/', $useragent)) {
            $browser = new WebMasterAid($useragent, []);
        } elseif (preg_match('/AboutUsBot Johnny5/', $useragent)) {
            $browser = new AboutUsBotJohnny5($useragent, []);
        } elseif (preg_match('/AboutUsBot/', $useragent)) {
            $browser = new AboutUsBot($useragent, []);
        } elseif (preg_match('/semantic\-visions\.com crawler/', $useragent)) {
            $browser = new SemanticVisionsCrawler($useragent, []);
        } elseif (preg_match('/waybackarchive\.org/', $useragent)) {
            $browser = new WaybackArchive($useragent, []);
        } elseif (preg_match('/OpenVAS/', $useragent)) {
            $browser = new OpenVulnerabilityAssessmentSystem($useragent, []);
        } elseif (preg_match('/MixrankBot/', $useragent)) {
            $browser = new MixrankBot($useragent, []);
        } elseif (preg_match('/InfegyAtlas/', $useragent)) {
            $browser = new InfegyAtlasBot($useragent, []);
        } elseif (preg_match('/MojeekBot/', $useragent)) {
            $browser = new MojeekBot($useragent, []);
        } elseif (preg_match('/memorybot/i', $useragent)) {
            $browser = new MemoryBot($useragent, []);
        } elseif (preg_match('/DomainAppender/', $useragent)) {
            $browser = new DomainAppenderBot($useragent, []);
        } elseif (preg_match('/GIDBot/', $useragent)) {
            $browser = new GidBot($useragent, []);
        } elseif (preg_match('/DBot/', $useragent)) {
            $browser = new Dbot($useragent, []);
        } elseif (preg_match('/PWBot/', $useragent)) {
            $browser = new PwBot($useragent, []);
        } elseif (preg_match('/\+5Bot/', $useragent)) {
            $browser = new Plus5Bot($useragent, []);
        } elseif (preg_match('/WASALive\-Bot/', $useragent)) {
            $browser = new WasaLiveBot($useragent, []);
        } elseif (preg_match('/OpenHoseBot/', $useragent)) {
            $browser = new OpenHoseBot($useragent, []);
        } elseif (preg_match('/URLfilterDB\-crawler/', $useragent)) {
            $browser = new UrlfilterDbCrawler($useragent, []);
        } elseif (preg_match('/metager2\-verification\-bot/', $useragent)) {
            $browser = new Metager2VerificationBot($useragent, []);
        } elseif (preg_match('/Powermarks/', $useragent)) {
            $browser = new Powermarks($useragent, []);
        } elseif (preg_match('/CloudFlare\-AlwaysOnline/', $useragent)) {
            $browser = new CloudFlareAlwaysOnline($useragent, []);
        } elseif (preg_match('/Phantom\.js bot/', $useragent)) {
            $browser = new PhantomJsBot($useragent, []);
        } elseif (preg_match('/Phantom/', $useragent)) {
            $browser = new PhantomBrowser($useragent, []);
        } elseif (preg_match('/Shrook/', $useragent)) {
            $browser = new Shrook($useragent, []);
        } elseif (preg_match('/netEstate NE Crawler/', $useragent)) {
            $browser = new NetEstateCrawler($useragent, []);
        } elseif (preg_match('/garlikcrawler/i', $useragent)) {
            $browser = new GarlikCrawler($useragent, []);
        } elseif (preg_match('/metageneratorcrawler/i', $useragent)) {
            $browser = new MetaGeneratorCrawler($useragent, []);
        } elseif (preg_match('/ScreenerBot/', $useragent)) {
            $browser = new ScreenerBot($useragent, []);
        } elseif (preg_match('/WebTarantula\.com Crawler/', $useragent)) {
            $browser = new WebTarantula($useragent, []);
        } elseif (preg_match('/BacklinkCrawler/', $useragent)) {
            $browser = new BacklinkCrawler($useragent, []);
        } elseif (preg_match('/LinksCrawler/', $useragent)) {
            $browser = new LinksCrawler($useragent, []);
        } elseif (preg_match('/(ssearch\_bot|sSearch Crawler)/', $useragent)) {
            $browser = new SsearchCrawler($useragent, []);
        } elseif (preg_match('/HRCrawler/', $useragent)) {
            $browser = new HrCrawler($useragent, []);
        } elseif (preg_match('/ICC\-Crawler/', $useragent)) {
            $browser = new IccCrawler($useragent, []);
        } elseif (preg_match('/Arachnida Web Crawler/', $useragent)) {
            $browser = new ArachnidaWebCrawler($useragent, []);
        } elseif (preg_match('/Finderlein Research Crawler/', $useragent)) {
            $browser = new FinderleinResearchCrawler($useragent, []);
        } elseif (preg_match('/TestCrawler/', $useragent)) {
            $browser = new TestCrawler($useragent, []);
        } elseif (preg_match('/Scopia Crawler/', $useragent)) {
            $browser = new ScopiaCrawler($useragent, []);
        } elseif (preg_match('/Crawler/', $useragent)) {
            $browser = new Crawler($useragent, []);
        } elseif (preg_match('/MetaJobBot/', $useragent)) {
            $browser = new MetaJobBot($useragent, []);
        } elseif (preg_match('/jig browser web/', $useragent)) {
            $browser = new JigBrowserWeb($useragent, []);
        } elseif (preg_match('/T\-H\-U\-N\-D\-E\-R\-S\-T\-O\-N\-E/', $useragent)) {
            $browser = new TexisWebscript($useragent, []);
        } elseif (preg_match('/focuseekbot/', $useragent)) {
            $browser = new Focuseekbot($useragent, []);
        } elseif (preg_match('/vBSEO/', $useragent)) {
            $browser = new VbulletinSeoBot($useragent, []);
        } elseif (preg_match('/kgbody/', $useragent)) {
            $browser = new Kgbody($useragent, []);
        } elseif (preg_match('/JobdiggerSpider/', $useragent)) {
            $browser = new JobdiggerSpider($useragent, []);
        } elseif (preg_match('/imrbot/', $useragent)) {
            $browser = new MignifyBot($useragent, []);
        } elseif (preg_match('/kulturarw3/', $useragent)) {
            $browser = new Kulturarw3($useragent, []);
        } elseif (preg_match('/LucidWorks/', $useragent)) {
            $browser = new LucidworksBot($useragent, []);
        } elseif (preg_match('/MerchantCentricBot/', $useragent)) {
            $browser = new MerchantCentricBot($useragent, []);
        } elseif (preg_match('/Nett\.io bot/', $useragent)) {
            $browser = new NettioBot($useragent, []);
        } elseif (preg_match('/SemanticBot/', $useragent)) {
            $browser = new SemanticBot($useragent, []);
        } elseif (preg_match('/tweetedtimes/i', $useragent)) {
            $browser = new TweetedTimesBot($useragent, []);
        } elseif (preg_match('/vkShare/', $useragent)) {
            $browser = new VkShare($useragent, []);
        } elseif (preg_match('/Yahoo Ad monitoring/', $useragent)) {
            $browser = new YahooAdMonitoring($useragent, []);
        } elseif (preg_match('/YioopBot/', $useragent)) {
            $browser = new YioopBot($useragent, []);
        } elseif (preg_match('/zitebot/', $useragent)) {
            $browser = new Zitebot($useragent, []);
        } elseif (preg_match('/Espial/', $useragent)) {
            $browser = new EspialTvBrowser($useragent, []);
        } elseif (preg_match('/SiteCon/', $useragent)) {
            $browser = new SiteCon($useragent, []);
        } elseif (preg_match('/iBooks Author/', $useragent)) {
            $browser = new IbooksAuthor($useragent, []);
        } elseif (preg_match('/iWeb/', $useragent)) {
            $browser = new Iweb($useragent, []);
        } elseif (preg_match('/NewsFire/', $useragent)) {
            $browser = new NewsFire($useragent, []);
        } elseif (preg_match('/RMSnapKit/', $useragent)) {
            $browser = new RmSnapKit($useragent, []);
        } elseif (preg_match('/Sandvox/', $useragent)) {
            $browser = new Sandvox($useragent, []);
        } elseif (preg_match('/TubeTV/', $useragent)) {
            $browser = new TubeTv($useragent, []);
        } elseif (preg_match('/Elluminate Live/', $useragent)) {
            $browser = new ElluminateLive($useragent, []);
        } elseif (preg_match('/Element Browser/', $useragent)) {
            $browser = new ElementBrowser($useragent, []);
        } elseif (preg_match('/K\-Meleon/', $useragent)) {
            $browser = new Kmeleon($useragent, []);
        } elseif (preg_match('/Esribot/', $useragent)) {
            $browser = new Esribot($useragent, []);
        } elseif (preg_match('/QuickLook/', $useragent)) {
            $browser = new QuickLook($useragent, []);
        } elseif (preg_match('/dillo/i', $useragent)) {
            $browser = new Dillo($useragent, []);
        } elseif (preg_match('/Digg/', $useragent)) {
            $browser = new DiggBot($useragent, []);
        } elseif (preg_match('/Zetakey/', $useragent)) {
            $browser = new ZetakeyBrowser($useragent, []);
        } elseif (preg_match('/getprismatic\.com/', $useragent)) {
            $browser = new PrismaticApp($useragent, []);
        } elseif (preg_match('/(FOMA|SH05C)/', $useragent)) {
            $browser = new Sharp($useragent, []);
        } elseif (preg_match('/OpenWebKitSharp/', $useragent)) {
            $browser = new OpenWebkitSharp($useragent, []);
        } elseif (preg_match('/AjaxSnapBot/', $useragent)) {
            $browser = new AjaxSnapBot($useragent, []);
        } elseif (preg_match('/Owler/', $useragent)) {
            $browser = new OwlerBot($useragent, []);
        } elseif (preg_match('/Yahoo Link Preview/', $useragent)) {
            $browser = new YahooLinkPreview($useragent, []);
        } elseif (preg_match('/pub\-crawler/', $useragent)) {
            $browser = new PubCrawler($useragent, []);
        } elseif (preg_match('/Kraken/', $useragent)) {
            $browser = new Kraken($useragent, []);
        } elseif (preg_match('/Qwantify/', $useragent)) {
            $browser = new Qwantify($useragent, []);
        } elseif (preg_match('/SetLinks bot/', $useragent)) {
            $browser = new SetLinksCrawler($useragent, []);
        } elseif (preg_match('/MegaIndex\.ru/', $useragent)) {
            $browser = new MegaIndexBot($useragent, []);
        } elseif (preg_match('/Cliqzbot/', $useragent)) {
            $browser = new Cliqzbot($useragent, []);
        } elseif (preg_match('/DAWINCI ANTIPLAG SPIDER/', $useragent)) {
            $browser = new DawinciAntiplagSpider($useragent, []);
        } elseif (preg_match('/AdvBot/', $useragent)) {
            $browser = new AdvBot($useragent, []);
        } elseif (preg_match('/DuckDuckGo\-Favicons\-Bot/', $useragent)) {
            $browser = new DuckDuckFaviconsBot($useragent, []);
        } elseif (preg_match('/ZyBorg/', $useragent)) {
            $browser = new WiseNutSearchEngineCrawler($useragent, []);
        } elseif (preg_match('/HyperCrawl/', $useragent)) {
            $browser = new HyperCrawl($useragent, []);
        } elseif (preg_match('/ARCHIVE\.ORG\.UA crawler/', $useragent)) {
            $browser = new ArchiveOrgBot($useragent, []);
        } elseif (preg_match('/worldwebheritage/', $useragent)) {
            $browser = new WorldwebheritageBot($useragent, []);
        } elseif (preg_match('/BegunAdvertising/', $useragent)) {
            $browser = new BegunAdvertisingBot($useragent, []);
        } elseif (preg_match('/TrendWinHttp/', $useragent)) {
            $browser = new TrendWinHttp($useragent, []);
        } elseif (preg_match('/(winhttp|winhttprequest)/i', $useragent)) {
            $browser = new WinHttpRequest($useragent, []);
        } elseif (preg_match('/SkypeUriPreview/', $useragent)) {
            $browser = new SkypeUriPreview($useragent, []);
        } elseif (preg_match('/ScoutJet/', $useragent)) {
            $browser = new Scoutjet($useragent, []);
        } elseif (preg_match('/Lipperhey\-Kaus\-Australis/', $useragent)) {
            $browser = new LipperheyKausAustralis($useragent, []);
        } elseif (preg_match('/Digincore bot/', $useragent)) {
            $browser = new DigincoreBot($useragent, []);
        } elseif (preg_match('/Steeler/', $useragent)) {
            $browser = new Steeler($useragent, []);
        } elseif (preg_match('/Orangebot/', $useragent)) {
            $browser = new Orangebot($useragent, []);
        } elseif (preg_match('/Jasmine/', $useragent)) {
            $browser = new Jasmine($useragent, []);
        } elseif (preg_match('/electricmonk/', $useragent)) {
            $browser = new DueDilCrawler($useragent, []);
        } elseif (preg_match('/yoozBot/', $useragent)) {
            $browser = new YoozBot($useragent, []);
        } elseif (preg_match('/online\-webceo\-bot/', $useragent)) {
            $browser = new WebceoBot($useragent, []);
        } elseif (preg_match('/^Mozilla\/5\.0 \(.*\) Gecko\/.*\/\d+/', $useragent)
            && !preg_match('/Netscape/', $useragent)
        ) {
            $browser = new Firefox($useragent, []);
        } elseif (preg_match('/^Mozilla\/5\.0 \(.*rv:\d+\.\d+.*\) Gecko\/.*\//', $useragent)
            && !preg_match('/Netscape/', $useragent)
        ) {
            $browser = new Firefox($useragent, []);
        } elseif (preg_match('/Netscape/', $useragent)) {
            $browser = new Netscape($useragent, []);
        } elseif (preg_match('/^Mozilla\/5\.0$/', $useragent)) {
            $browser = new UnknownBrowser($useragent, []);
        } elseif (preg_match('/Virtuoso/', $useragent)) {
            $browser = new Virtuoso($useragent, []);
        } elseif (preg_match('/^Mozilla\/(3|4)\.\d+/', $useragent, $matches)
            && !preg_match('/(msie|android)/i', $useragent, $matches)
        ) {
            $browser = new Netscape($useragent, []);
        } elseif (preg_match('/^Dalvik\/\d/', $useragent)) {
            $browser = new Dalvik($useragent, []);
        } elseif (preg_match('/niki\-bot/', $useragent)) {
            $browser = new NikiBot($useragent, []);
        } elseif (preg_match('/ContextAd Bot/', $useragent)) {
            $browser = new ContextadBot($useragent, []);
        } elseif (preg_match('/integrity/', $useragent)) {
            $browser = new Integrity($useragent, []);
        } elseif (preg_match('/masscan/', $useragent)) {
            $browser = new DownloadAccelerator($useragent, []);
        } elseif (preg_match('/ZmEu/', $useragent)) {
            $browser = new ZmEu($useragent, []);
        } elseif (preg_match('/sogou web spider/i', $useragent)) {
            $browser = new SogouWebSpider($useragent, []);
        } elseif (preg_match('/(OpenWave|UP\.Browser|UP\/)/', $useragent)) {
            $browser = new Openwave($useragent, []);
        } elseif (preg_match('/(ObigoInternetBrowser|obigo\-browser|Obigo|Teleca)(\/|-)Q(\d+)/', $useragent)) {
            $browser = new ObigoQ($useragent, []);
        } elseif (preg_match('/(Teleca|Obigo|MIC\/|AU\-MIC)/', $useragent)) {
            $browser = new TelecaObigo($useragent, []);
        } elseif (preg_match('/DavClnt/', $useragent)) {
            $browser = new MicrosoftWebDav($useragent, []);
        } elseif (preg_match('/XING\-contenttabreceiver/', $useragent)) {
            $browser = new XingContenttabreceiver($useragent, []);
        } elseif (preg_match('/Slingstone/', $useragent)) {
            $browser = new YahooSlingstone($useragent, []);
        } elseif (preg_match('/BOT for JCE/', $useragent)) {
            $browser = new BotForJce($useragent, []);
        } elseif (preg_match('/Validator\.nu\/LV/', $useragent)) {
            $browser = new W3cValidatorNuLv($useragent, []);
        } elseif (preg_match('/Curb/', $useragent)) {
            $browser = new Curb($useragent, []);
        } elseif (preg_match('/link_thumbnailer/', $useragent)) {
            $browser = new LinkThumbnailer($useragent, []);
        } elseif (preg_match('/Ruby/', $useragent)) {
            $browser = new Ruby($useragent, []);
        } elseif (preg_match('/securepoint cf/', $useragent)) {
            $browser = new SecurepointContentFilter($useragent, []);
        } elseif (preg_match('/sogou\-spider/i', $useragent)) {
            $browser = new SogouSpider($useragent, []);
        } elseif (preg_match('/rankflex/i', $useragent)) {
            $browser = new RankFlex($useragent, []);
        } elseif (preg_match('/domnutch/i', $useragent)) {
            $browser = new Domnutch($useragent, []);
        } elseif (preg_match('/discovered/i', $useragent)) {
            $browser = new DiscoverEd($useragent, []);
        } elseif (preg_match('/nutch/i', $useragent)) {
            $browser = new Nutch($useragent, []);
        } elseif (preg_match('/boardreader favicon fetcher/i', $useragent)) {
            $browser = new BoardReaderFaviconFetcher($useragent, []);
        } elseif (preg_match('/checksite verification agent/i', $useragent)) {
            $browser = new CheckSiteVerificationAgent($useragent, []);
        } elseif (preg_match('/experibot/i', $useragent)) {
            $browser = new Experibot($useragent, []);
        } elseif (preg_match('/feedblitz/i', $useragent)) {
            $browser = new FeedBlitz($useragent, []);
        } elseif (preg_match('/rss2html/i', $useragent)) {
            $browser = new Rss2Html($useragent, []);
        } elseif (preg_match('/feedlyapp/i', $useragent)) {
            $browser = new FeedlyApp($useragent, []);
        } elseif (preg_match('/genderanalyzer/i', $useragent)) {
            $browser = new Genderanalyzer($useragent, []);
        } elseif (preg_match('/gooblog/i', $useragent)) {
            $browser = new GooBlog($useragent, []);
        } elseif (preg_match('/tumblr/i', $useragent)) {
            $browser = new TumblrApp($useragent, []);
        } elseif (preg_match('/w3c\_i18n\-checker/i', $useragent)) {
            $browser = new W3cI18nChecker($useragent, []);
        } elseif (preg_match('/w3c\_unicorn/i', $useragent)) {
            $browser = new W3cUnicorn($useragent, []);
        } elseif (preg_match('/alltop/i', $useragent)) {
            $browser = new AlltopApp($useragent, []);
        } elseif (preg_match('/internetseer/i', $useragent)) {
            $browser = new InternetSeer($useragent, []);
        } elseif (preg_match('/ADmantX Platform Semantic Analyzer/', $useragent)) {
            $browser = new AdmantxPlatformSemanticAnalyzer($useragent, []);
        } elseif (preg_match('/UniversalFeedParser/', $useragent)) {
            $browser = new UniversalFeedParser($useragent, []);
        } elseif (preg_match('/(binlar|larbin)/i', $useragent)) {
            $browser = new Larbin($useragent, []);
        } elseif (preg_match('/unityplayer/i', $useragent)) {
            $browser = new UnityWebPlayer($useragent, []);
        } elseif (preg_match('/WeSEE\:Search/', $useragent)) {
            $browser = new WeseeSearch($useragent, []);
        } elseif (preg_match('/WeSEE\:Ads/', $useragent)) {
            $browser = new WeseeAds($useragent, []);
        } elseif (preg_match('/A6\-Indexer/', $useragent)) {
            $browser = new A6Indexer($useragent, []);
        } elseif (preg_match('/NerdyBot/', $useragent)) {
            $browser = new NerdyBot($useragent, []);
        } elseif (preg_match('/Peeplo Screenshot Bot/', $useragent)) {
            $browser = new PeeploScreenshotBot($useragent, []);
        } elseif (preg_match('/CCBot/', $useragent)) {
            $browser = new CcBot($useragent, []);
        } elseif (preg_match('/visionutils/', $useragent)) {
            $browser = new VisionUtils($useragent, []);
        } elseif (preg_match('/Feedly/', $useragent)) {
            $browser = new Feedly($useragent, []);
        } elseif (preg_match('/Photon/', $useragent)) {
            $browser = new Photon($useragent, []);
        } elseif (preg_match('/WDG\_Validator/', $useragent)) {
            $browser = new WdgHtmlValidator($useragent, []);
        } elseif (preg_match('/Aboundex/', $useragent)) {
            $browser = new Aboundexbot($useragent, []);
        } elseif (preg_match('/YisouSpider/', $useragent)) {
            $browser = new YisouSpider($useragent, []);
        } elseif (preg_match('/hivaBot/', $useragent)) {
            $browser = new HivaBot($useragent, []);
        } elseif (preg_match('/Comodo Spider/', $useragent)) {
            $browser = new ComodoSpider($useragent, []);
        } elseif (preg_match('/OpenWebSpider/i', $useragent)) {
            $browser = new OpenWebSpider($useragent, []);
        } elseif (preg_match('/R6_CommentReader/i', $useragent)) {
            $browser = new R6CommentReader($useragent, []);
        } elseif (preg_match('/R6_FeedFetcher/i', $useragent)) {
            $browser = new R6Feedfetcher($useragent, []);
        } elseif (preg_match('/(psbot\-image|psbot\-page)/i', $useragent)) {
            $browser = new Picsearchbot($useragent, []);
        } elseif (preg_match('/Bloglovin/', $useragent)) {
            $browser = new BloglovinBot($useragent, []);
        } elseif (preg_match('/viralvideochart/i', $useragent)) {
            $browser = new ViralvideochartBot($useragent, []);
        } elseif (preg_match('/MetaHeadersBot/', $useragent)) {
            $browser = new MetaHeadersBot($useragent, []);
        } elseif (preg_match('/Zend\_Http\_Client/', $useragent)) {
            $browser = new ZendHttpClient($useragent, []);
        } elseif (preg_match('/wget/i', $useragent)) {
            $browser = new Wget($useragent, []);
        } elseif (preg_match('/Scrapy/', $useragent)) {
            $browser = new ScrapyBot($useragent, []);
        } elseif (preg_match('/Moozilla/', $useragent)) {
            $browser = new Moozilla($useragent, []);
        } elseif (preg_match('/AntBot/', $useragent)) {
            $browser = new AntBot($useragent, []);
        } elseif (preg_match('/Browsershots/', $useragent)) {
            $browser = new Browsershots($useragent, []);
        } elseif (preg_match('/revolt/', $useragent)) {
            $browser = new BotRevolt($useragent, []);
        } elseif (preg_match('/pdrlabs/i', $useragent)) {
            $browser = new PdrlabsBot($useragent, []);
        } elseif (preg_match('/elinks/i', $useragent)) {
            $browser = new Elinks($useragent, []);
        } elseif (preg_match('/Links/', $useragent)) {
            $browser = new Links($useragent, []);
        } elseif (preg_match('/Airmail/', $useragent)) {
            $browser = new Airmail($useragent, []);
        } elseif (preg_match('/SonyEricsson/', $useragent)) {
            $browser = new SonyEricsson($useragent, []);
        } elseif (preg_match('/WEB\.DE MailCheck/', $useragent)) {
            $browser = new WebdeMailCheck($useragent, []);
        } elseif (preg_match('/Screaming Frog SEO Spider/', $useragent)) {
            $browser = new ScreamingFrogSeoSpider($useragent, []);
        } elseif (preg_match('/AndroidDownloadManager/', $useragent)) {
            $browser = new AndroidDownloadManager($useragent, []);
        } elseif (preg_match('/Go ([\d\.]+) package http/', $useragent)) {
            $browser = new GoHttpClient($useragent, []);
        } elseif (preg_match('/Go-http-client/', $useragent)) {
            $browser = new GoHttpClient($useragent, []);
        } elseif (preg_match('/Proxy Gear Pro/', $useragent)) {
            $browser = new ProxyGearPro($useragent, []);
        } elseif (preg_match('/WAP Browser\/MAUI/', $useragent)) {
            $browser = new MauiWapBrowser($useragent, []);
        } elseif (preg_match('/Tiny Tiny RSS/', $useragent)) {
            $browser = new TinyTinyRss($useragent, []);
        } elseif (preg_match('/Readability/', $useragent)) {
            $browser = new Readability($useragent, []);
        } elseif (preg_match('/NSPlayer/', $useragent)) {
            $browser = new WindowsMediaPlayer($useragent, []);
        } elseif (preg_match('/Pingdom/', $useragent)) {
            $browser = new Pingdom($useragent, []);
        } elseif (preg_match('/crazywebcrawler/i', $useragent)) {
            $browser = new Crazywebcrawler($useragent, []);
        } elseif (preg_match('/GG PeekBot/', $useragent)) {
            $browser = new GgPeekBot($useragent, []);
        } elseif (preg_match('/iTunes/', $useragent)) {
            $browser = new Itunes($useragent, []);
        } elseif (preg_match('/LibreOffice/', $useragent)) {
            $browser = new LibreOffice($useragent, []);
        } elseif (preg_match('/OpenOffice/', $useragent)) {
            $browser = new OpenOffice($useragent, []);
        } elseif (preg_match('/ThumbnailAgent/', $useragent)) {
            $browser = new ThumbnailAgent($useragent, []);
        } elseif (preg_match('/LinkStats Bot/', $useragent)) {
            $browser = new LinkStatsBot($useragent, []);
        } elseif (preg_match('/eZ Publish Link Validator/', $useragent)) {
            $browser = new EzPublishLinkValidator($useragent, []);
        } elseif (preg_match('/ThumbSniper/', $useragent)) {
            $browser = new ThumbSniper($useragent, []);
        } elseif (preg_match('/stq\_bot/', $useragent)) {
            $browser = new SearchteqBot($useragent, []);
        } elseif (preg_match('/SNK Screenshot Bot/', $useragent)) {
            $browser = new SnkScreenshotBot($useragent, []);
        } elseif (preg_match('/SynHttpClient/', $useragent)) {
            $browser = new SynHttpClient($useragent, []);
        } elseif (preg_match('/HTTPClient/', $useragent)) {
            $browser = new HttpClient($useragent, []);
        } elseif (preg_match('/T\-Online Browser/', $useragent)) {
            $browser = new TonlineBrowser($useragent, []);
        } elseif (preg_match('/ImplisenseBot/', $useragent)) {
            $browser = new ImplisenseBot($useragent, []);
        } elseif (preg_match('/BuiBui\-Bot/', $useragent)) {
            $browser = new BuiBuiBot($useragent, []);
        } elseif (preg_match('/thumbshots\-de\-bot/', $useragent)) {
            $browser = new ThumbShotsDeBot($useragent, []);
        } elseif (preg_match('/python\-requests/', $useragent)) {
            $browser = new PythonRequests($useragent, []);
        } elseif (preg_match('/Python\-urllib/', $useragent)) {
            $browser = new PythonUrlLib($useragent, []);
        } elseif (preg_match('/Bot\.AraTurka\.com/', $useragent)) {
            $browser = new BotAraTurka($useragent, []);
        } elseif (preg_match('/http\_requester/', $useragent)) {
            $browser = new HttpRequester($useragent, []);
        } elseif (preg_match('/WhatWeb/', $useragent)) {
            $browser = new WhatWebWebScanner($useragent, []);
        } elseif (preg_match('/isc header collector handlers/', $useragent)) {
            $browser = new IscHeaderCollectorHandlers($useragent, []);
        } elseif (preg_match('/Thumbor/', $useragent)) {
            $browser = new Thumbor($useragent, []);
        } elseif (preg_match('/Forum Poster/', $useragent)) {
            $browser = new ForumPoster($useragent, []);
        } elseif (preg_match('/crawler4j/', $useragent)) {
            $browser = new Crawler4j($useragent, []);
        } elseif (preg_match('/Facebot/', $useragent)) {
            $browser = new FaceBot($useragent, []);
        } elseif (preg_match('/NetzCheckBot/', $useragent)) {
            $browser = new NetzCheckBot($useragent, []);
        } elseif (preg_match('/MIB/', $useragent)) {
            $browser = new MotorolaInternetBrowser($useragent, []);
        } elseif (preg_match('/facebookscraper/', $useragent)) {
            $browser = new Facebookscraper($useragent, []);
        } elseif (preg_match('/Zookabot/', $useragent)) {
            $browser = new Zookabot($useragent, []);
        } elseif (preg_match('/MetaURI/', $useragent)) {
            $browser = new MetaUri($useragent, []);
        } elseif (preg_match('/FreeWebMonitoring SiteChecker/', $useragent)) {
            $browser = new FreeWebMonitoringSiteChecker($useragent, []);
        } elseif (preg_match('/IPv4Scan/', $useragent)) {
            $browser = new Ipv4Scan($useragent, []);
        } elseif (preg_match('/RED/', $useragent)) {
            $browser = new Redbot($useragent, []);
        } elseif (preg_match('/domainsbot/', $useragent)) {
            $browser = new DomainsBot($useragent, []);
        } elseif (preg_match('/BUbiNG/', $useragent)) {
            $browser = new Bubing($useragent, []);
        } elseif (preg_match('/RamblerMail/', $useragent)) {
            $browser = new RamblerMail($useragent, []);
        } elseif (preg_match('/ichiro\/mobile/', $useragent)) {
            $browser = new IchiroMobileBot($useragent, []);
        } elseif (preg_match('/ichiro/', $useragent)) {
            $browser = new IchiroBot($useragent, []);
        } elseif (preg_match('/iisbot/', $useragent)) {
            $browser = new IisBot($useragent, []);
        } elseif (preg_match('/JoobleBot/', $useragent)) {
            $browser = new JoobleBot($useragent, []);
        } elseif (preg_match('/Superfeedr bot/', $useragent)) {
            $browser = new SuperfeedrBot($useragent, []);
        } elseif (preg_match('/FeedBurner/', $useragent)) {
            $browser = new FeedBurner($useragent, []);
        } elseif (preg_match('/Fastladder/', $useragent)) {
            $browser = new FastladderFeedFetcher($useragent, []);
        } elseif (preg_match('/livedoor/', $useragent)) {
            $browser = new LivedoorFeedFetcher($useragent, []);
        } elseif (preg_match('/Icarus6j/', $useragent)) {
            $browser = new Icarus6j($useragent, []);
        } elseif (preg_match('/wsr\-agent/', $useragent)) {
            $browser = new WsrAgent($useragent, []);
        } elseif (preg_match('/Blogshares Spiders/', $useragent)) {
            $browser = new BlogsharesSpiders($useragent, []);
        } elseif (preg_match('/TinEye\-bot/', $useragent)) {
            $browser = new TinEyeBot($useragent, []);
        } elseif (preg_match('/QuickiWiki/', $useragent)) {
            $browser = new QuickiWikiBot($useragent, []);
        } elseif (preg_match('/PycURL/', $useragent)) {
            $browser = new PyCurl($useragent, []);
        } elseif (preg_match('/libcurl\-agent/', $useragent)) {
            $browser = new Libcurl($useragent, []);
        } elseif (preg_match('/Taproot/', $useragent)) {
            $browser = new TaprootBot($useragent, []);
        } elseif (preg_match('/GuzzleHttp/', $useragent)) {
            $browser = new GuzzleHttpClient($useragent, []);
        } elseif (preg_match('/curl/i', $useragent)) {
            $browser = new Curl($useragent, []);
        } elseif (preg_match('/^PHP/', $useragent)) {
            $browser = new Php($useragent, []);
        } elseif (preg_match('/Apple\-PubSub/', $useragent)) {
            $browser = new ApplePubSub($useragent, []);
        } elseif (preg_match('/SimplePie/', $useragent)) {
            $browser = new SimplePie($useragent, []);
        } elseif (preg_match('/BigBozz/', $useragent)) {
            $browser = new BigBozz($useragent, []);
        } elseif (preg_match('/ECCP/', $useragent)) {
            $browser = new Eccp($useragent, []);
        } elseif (preg_match('/facebookexternalhit/', $useragent)) {
            $browser = new FacebookExternalHit($useragent, []);
        } elseif (preg_match('/GigablastOpenSource/', $useragent)) {
            $browser = new GigablastOpenSource($useragent, []);
        } elseif (preg_match('/WebIndex/', $useragent)) {
            $browser = new WebIndex($useragent, []);
        } elseif (preg_match('/Prince/', $useragent)) {
            $browser = new Prince($useragent, []);
        } elseif (preg_match('/adsense\-snapshot\-google/i', $useragent)) {
            $browser = new GoogleAdsenseSnapshot($useragent, []);
        } elseif (preg_match('/Amazon CloudFront/', $useragent)) {
            $browser = new AmazonCloudFront($useragent, []);
        } elseif (preg_match('/bandscraper/', $useragent)) {
            $browser = new Bandscraper($useragent, []);
        } elseif (preg_match('/bitlybot/', $useragent)) {
            $browser = new BitlyBot($useragent, []);
        } elseif (preg_match('/^bot$/', $useragent)) {
            $browser = new BotBot($useragent, []);
        } elseif (preg_match('/cars\-app\-browser/', $useragent)) {
            $browser = new CarsAppBrowser($useragent, []);
        } elseif (preg_match('/Coursera\-Mobile/', $useragent)) {
            $browser = new CourseraMobileApp($useragent, []);
        } elseif (preg_match('/Crowsnest/', $useragent)) {
            $browser = new CrowsnestMobileApp($useragent, []);
        } elseif (preg_match('/Dorado WAP\-Browser/', $useragent)) {
            $browser = new DoradoWapBrowser($useragent, []);
        } elseif (preg_match('/Goldfire Server/', $useragent)) {
            $browser = new GoldfireServer($useragent, []);
        } elseif (preg_match('/EventMachine HttpClient/', $useragent)) {
            $browser = new EventMachineHttpClient($useragent, []);
        } elseif (preg_match('/iBall/', $useragent)) {
            $browser = new Iball($useragent, []);
        } elseif (preg_match('/InAGist URL Resolver/', $useragent)) {
            $browser = new InagistUrlResolver($useragent, []);
        } elseif (preg_match('/Jeode/', $useragent)) {
            $browser = new Jeode($useragent, []);
        } elseif (preg_match('/kraken/', $useragent)) {
            $browser = new Krakenjs($useragent, []);
        } elseif (preg_match('/com\.linkedin/', $useragent)) {
            $browser = new LinkedInBot($useragent, []);
        } elseif (preg_match('/LivelapBot/', $useragent)) {
            $browser = new LivelapBot($useragent, []);
        } elseif (preg_match('/MixBot/', $useragent)) {
            $browser = new MixBot($useragent, []);
        } elseif (preg_match('/BuSecurityProject/', $useragent)) {
            $browser = new BuSecurityProject($useragent, []);
        } elseif (preg_match('/PageFreezer/', $useragent)) {
            $browser = new PageFreezer($useragent, []);
        } elseif (preg_match('/restify/', $useragent)) {
            $browser = new Restify($useragent, []);
        } elseif (preg_match('/ShowyouBot/', $useragent)) {
            $browser = new ShowyouBot($useragent, []);
        } elseif (preg_match('/vlc/i', $useragent)) {
            $browser = new VlcMediaPlayer($useragent, []);
        } elseif (preg_match('/WebRingChecker/', $useragent)) {
            $browser = new WebRingChecker($useragent, []);
        } elseif (preg_match('/bot\-pge\.chlooe\.com/', $useragent)) {
            $browser = new ChlooeBot($useragent, []);
        } elseif (preg_match('/seebot/', $useragent)) {
            $browser = new SeeBot($useragent, []);
        } elseif (preg_match('/ltx71/', $useragent)) {
            $browser = new Ltx71($useragent, []);
        } elseif (preg_match('/CookieReports/', $useragent)) {
            $browser = new CookieReportsBot($useragent, []);
        } elseif (preg_match('/Elmer/', $useragent)) {
            $browser = new Elmer($useragent, []);
        } elseif (preg_match('/Iframely/', $useragent)) {
            $browser = new IframelyBot($useragent, []);
        } elseif (preg_match('/MetaInspector/', $useragent)) {
            $browser = new MetaInspector($useragent, []);
        } elseif (preg_match('/Microsoft\-CryptoAPI/', $useragent)) {
            $browser = new MicrosoftCryptoApi($useragent, []);
        } elseif (preg_match('/OWASP\_SECRET\_BROWSER/', $useragent)) {
            $browser = new OwaspSecretBrowser($useragent, []);
        } elseif (preg_match('/SMRF URL Expander/', $useragent)) {
            $browser = new SmrfUrlExpander($useragent, []);
        } elseif (preg_match('/Speedy Spider/', $useragent)) {
            $browser = new Entireweb($useragent, []);
        } elseif (preg_match('/kizasi\-spider/', $useragent)) {
            $browser = new Kizasispider($useragent, []);
        } elseif (preg_match('/Superarama\.com \- BOT/', $useragent)) {
            $browser = new SuperaramaComBot($useragent, []);
        } elseif (preg_match('/WNMbot/', $useragent)) {
            $browser = new Wnmbot($useragent, []);
        } elseif (preg_match('/Website Explorer/', $useragent)) {
            $browser = new WebsiteExplorer($useragent, []);
        } elseif (preg_match('/city\-map screenshot service/', $useragent)) {
            $browser = new CitymapScreenshotService($useragent, []);
        } elseif (preg_match('/gosquared\-thumbnailer/', $useragent)) {
            $browser = new GosquaredThumbnailer($useragent, []);
        } elseif (preg_match('/optivo\(R\) NetHelper/', $useragent)) {
            $browser = new OptivoNetHelper($useragent, []);
        } elseif (preg_match('/pr\-cy\.ru Screenshot Bot/', $useragent)) {
            $browser = new ScreenshotBot($useragent, []);
        } elseif (preg_match('/Cyberduck/', $useragent)) {
            $browser = new Cyberduck($useragent, []);
        } elseif (preg_match('/Lynx/', $useragent)) {
            $browser = new Lynx($useragent, []);
        } elseif (preg_match('/AccServer/', $useragent)) {
            $browser = new AccServer($useragent, []);
        } elseif (preg_match('/SafeSearch microdata crawler/', $useragent)) {
            $browser = new SafeSearchMicrodataCrawler($useragent, []);
        } elseif (preg_match('/iZSearch/', $useragent)) {
            $browser = new IzSearchBot($useragent, []);
        } elseif (preg_match('/NetLyzer FastProbe/', $useragent)) {
            $browser = new NetLyzerFastProbe($useragent, []);
        } elseif (preg_match('/MnoGoSearch/', $useragent)) {
            $browser = new MnogoSearch($useragent, []);
        } elseif (preg_match('/uipbot/', $useragent)) {
            $browser = new Uipbot($useragent, []);
        } elseif (preg_match('/mbot/', $useragent)) {
            $browser = new Mbot($useragent, []);
        } elseif (preg_match('/MS Web Services Client Protocol/', $useragent)) {
            $browser = new MicrosoftDotNetFrameworkClr($useragent, []);
        } elseif (preg_match('/(AtomicBrowser|AtomicLite)/', $useragent)) {
            $browser = new AtomicBrowser($useragent, []);
        } elseif (preg_match('/AppEngine\-Google/', $useragent)) {
            $browser = new GoogleAppEngine($useragent, []);
        } elseif (preg_match('/Feedfetcher\-Google/', $useragent)) {
            $browser = new GoogleFeedfetcher($useragent, []);
        } elseif (preg_match('/Google/', $useragent)) {
            $browser = new GoogleApp($useragent, []);
        } elseif (preg_match('/UnwindFetchor/', $useragent)) {
            $browser = new UnwindFetchor($useragent, []);
        } elseif (preg_match('/Perfect%20Browser/', $useragent)) {
            $browser = new PerfectBrowser($useragent, []);
        } elseif (preg_match('/Reeder/', $useragent)) {
            $browser = new Reeder($useragent, []);
        } elseif (preg_match('/FastBrowser/', $useragent)) {
            $browser = new FastBrowser($useragent, []);
        } elseif (preg_match('/CFNetwork/', $useragent)) {
            $browser = new CfNetwork($useragent, []);
        } elseif (preg_match('/Y\!J\-(ASR|BSC)/', $useragent)) {
            $browser = new YahooJapan($useragent, []);
        } elseif (preg_match('/test certificate info/', $useragent)) {
            $browser = new TestCertificateInfo($useragent, []);
        } elseif (preg_match('/fastbot crawler/', $useragent)) {
            $browser = new FastbotCrawler($useragent, []);
        } elseif (preg_match('/Riddler/', $useragent)) {
            $browser = new Riddler($useragent, []);
        } elseif (preg_match('/SophosUpdateManager/', $useragent)) {
            $browser = new SophosUpdateManager($useragent, []);
        } elseif (preg_match('/(Debian|Ubuntu) APT\-HTTP/', $useragent)) {
            $browser = new AptHttpTransport($useragent, []);
        } elseif (preg_match('/urlgrabber/', $useragent)) {
            $browser = new UrlGrabber($useragent, []);
        } elseif (preg_match('/UCS \(ESX\)/', $useragent)) {
            $browser = new UniventionCorporateServer($useragent, []);
        } elseif (preg_match('/libwww\-perl/', $useragent)) {
            $browser = new Libwww($useragent, []);
        } elseif (preg_match('/OpenBSD ftp/', $useragent)) {
            $browser = new OpenBsdFtp($useragent, []);
        } elseif (preg_match('/SophosAgent/', $useragent)) {
            $browser = new SophosAgent($useragent, []);
        } elseif (preg_match('/jupdate/', $useragent)) {
            $browser = new Jupdate($useragent, []);
        } elseif (preg_match('/Roku\/DVP/', $useragent)) {
            $browser = new RokuDvp($useragent, []);
        } elseif (preg_match('/VocusBot/', $useragent)) {
            $browser = new VocusBot($useragent, []);
        } elseif (preg_match('/PostRank/', $useragent)) {
            $browser = new PostRank($useragent, []);
        } elseif (preg_match('/rogerbot/i', $useragent)) {
            $browser = new Rogerbot($useragent, []);
        } elseif (preg_match('/Safeassign/', $useragent)) {
            $browser = new Safeassign($useragent, []);
        } elseif (preg_match('/ExaleadCloudView/', $useragent)) {
            $browser = new ExaleadCloudView($useragent, []);
        } elseif (preg_match('/Typhoeus/', $useragent)) {
            $browser = new Typhoeus($useragent, []);
        } elseif (preg_match('/Camo Asset Proxy/', $useragent)) {
            $browser = new CamoAssetProxy($useragent, []);
        } elseif (preg_match('/YahooCacheSystem/', $useragent)) {
            $browser = new YahooCacheSystem($useragent, []);
        } elseif (preg_match('/wmtips\.com/', $useragent)) {
            $browser = new WebmasterTipsBot($useragent, []);
        } elseif (preg_match('/linkCheck/', $useragent)) {
            $browser = new LinkCheck($useragent, []);
        } elseif (preg_match('/ABrowse/', $useragent)) {
            $browser = new Abrowse($useragent, []);
        } elseif (preg_match('/GWPImages/', $useragent)) {
            $browser = new GwpImages($useragent, []);
        } elseif (preg_match('/NoteTextView/', $useragent)) {
            $browser = new NoteTextView($useragent, []);
        } elseif (preg_match('/NING/', $useragent)) {
            $browser = new Ning($useragent, []);
        } elseif (preg_match('/Sprinklr/', $useragent)) {
            $browser = new SprinklrBot($useragent, []);
        } elseif (preg_match('/URLChecker/', $useragent)) {
            $browser = new UrlChecker($useragent, []);
        } elseif (preg_match('/newsme/', $useragent)) {
            $browser = new NewsMe($useragent, []);
        } elseif (preg_match('/Traackr/', $useragent)) {
            $browser = new Traackr($useragent, []);
        } elseif (preg_match('/nineconnections/', $useragent)) {
            $browser = new NineConnections($useragent, []);
        } elseif (preg_match('/Xenu Link Sleuth/', $useragent)) {
            $browser = new XenusLinkSleuth($useragent, []);
        } elseif (preg_match('/superagent/', $useragent)) {
            $browser = new Superagent($useragent, []);
        } elseif (preg_match('/Goose/', $useragent)) {
            $browser = new GooseExtractor($useragent, []);
        } elseif (preg_match('/AHC/', $useragent)) {
            $browser = new AsynchronousHttpClient($useragent, []);
        } elseif (preg_match('/newspaper/', $useragent)) {
            $browser = new Newspaper($useragent, []);
        } elseif (preg_match('/Hatena::Bookmark/', $useragent)) {
            $browser = new HatenaBookmark($useragent, []);
        } elseif (preg_match('/EasyBib AutoCite/', $useragent)) {
            $browser = new EasyBibAutoCite($useragent, []);
        } elseif (preg_match('/ShortLinkTranslate/', $useragent)) {
            $browser = new ShortLinkTranslate($useragent, []);
        } elseif (preg_match('/Marketing Grader/', $useragent)) {
            $browser = new MarketingGrader($useragent, []);
        } elseif (preg_match('/Grammarly/', $useragent)) {
            $browser = new Grammarly($useragent, []);
        } elseif (preg_match('/Dispatch/', $useragent)) {
            $browser = new Dispatch($useragent, []);
        } elseif (preg_match('/Raven Link Checker/', $useragent)) {
            $browser = new RavenLinkChecker($useragent, []);
        } elseif (preg_match('/http\-kit/', $useragent)) {
            $browser = new HttpKit($useragent, []);
        } elseif (preg_match('/sfFeedReader/', $useragent)) {
            $browser = new SymfonyRssReader($useragent, []);
        } elseif (preg_match('/Twikle/', $useragent)) {
            $browser = new TwikleBot($useragent, []);
        } elseif (preg_match('/node\-fetch/', $useragent)) {
            $browser = new NodeFetch($useragent, []);
        } elseif (preg_match('/BrokenLinkCheck\.com/', $useragent)) {
            $browser = new BrokenLinkCheck($useragent, []);
        } elseif (preg_match('/BCKLINKS/', $useragent)) {
            $browser = new BckLinks($useragent, []);
        } elseif (preg_match('/Faraday/', $useragent)) {
            $browser = new Faraday($useragent, []);
        } elseif (preg_match('/gettor/', $useragent)) {
            $browser = new Gettor($useragent, []);
        } elseif (preg_match('/SEOstats/', $useragent)) {
            $browser = new SeoStats($useragent, []);
        } elseif (preg_match('/ZnajdzFoto\/Image/', $useragent)) {
            $browser = new ZnajdzFotoImageBot($useragent, []);
        } elseif (preg_match('/infoX\-WISG/', $useragent)) {
            $browser = new InfoxWisg($useragent, []);
        } elseif (preg_match('/wscheck\.com/', $useragent)) {
            $browser = new WscheckBot($useragent, []);
        } elseif (preg_match('/Tweetminster/', $useragent)) {
            $browser = new TweetminsterBot($useragent, []);
        } elseif (preg_match('/Astute SRM/', $useragent)) {
            $browser = new AstuteSocial($useragent, []);
        } elseif (preg_match('/LongURL API/', $useragent)) {
            $browser = new LongUrlBot($useragent, []);
        } elseif (preg_match('/Trove/', $useragent)) {
            $browser = new TroveBot($useragent, []);
        } elseif (preg_match('/Melvil Favicon/', $useragent)) {
            $browser = new MelvilFaviconBot($useragent, []);
        } elseif (preg_match('/Melvil/', $useragent)) {
            $browser = new MelvilBot($useragent, []);
        } elseif (preg_match('/Pearltrees/', $useragent)) {
            $browser = new PearltreesBot($useragent, []);
        } elseif (preg_match('/Svven\-Summarizer/', $useragent)) {
            $browser = new SvvenSummarizerBot($useragent, []);
        } elseif (preg_match('/Athena Site Analyzer/', $useragent)) {
            $browser = new AthenaSiteAnalyzer($useragent, []);
        } elseif (preg_match('/Exploratodo/', $useragent)) {
            $browser = new ExploratodoBot($useragent, []);
        } elseif (preg_match('/WhatsApp/', $useragent)) {
            $browser = new WhatsApp($useragent, []);
        } elseif (preg_match('/DDG\-Android\-/', $useragent)) {
            $browser = new DuckDuckApp($useragent, []);
        } elseif (preg_match('/WebCorp/', $useragent)) {
            $browser = new WebCorp($useragent, []);
        } elseif (preg_match('/ROR Sitemap Generator/', $useragent)) {
            $browser = new RorSitemapGenerator($useragent, []);
        } elseif (preg_match('/AuditMyPC Webmaster Tool/', $useragent)) {
            $browser = new AuditmypcWebmasterTool($useragent, []);
        } elseif (preg_match('/XmlSitemapGenerator/', $useragent)) {
            $browser = new XmlSitemapGenerator($useragent, []);
        } elseif (preg_match('/Stratagems Kumo/', $useragent)) {
            $browser = new StratagemsKumo($useragent, []);
        } elseif (preg_match('/YOURLS/', $useragent)) {
            $browser = new Yourls($useragent, []);
        } elseif (preg_match('/Embed PHP Library/', $useragent)) {
            $browser = new EmbedPhpLibrary($useragent, []);
        } elseif (preg_match('/SPIP/', $useragent)) {
            $browser = new Spip($useragent, []);
        } elseif (preg_match('/Friendica/', $useragent)) {
            $browser = new Friendica($useragent, []);
        } elseif (preg_match('/MagpieRSS/', $useragent)) {
            $browser = new MagpieRss($useragent, []);
        } elseif (preg_match('/Short URL Checker/', $useragent)) {
            $browser = new ShortUrlChecker($useragent, []);
        } elseif (preg_match('/webnumbrFetcher/', $useragent)) {
            $browser = new WebnumbrFetcher($useragent, []);
        } elseif (preg_match('/(WAP Browser|Spice QT\-75|KKT20\/MIDP)/', $useragent)) {
            $browser = new WapBrowser($useragent, []);
        } elseif (preg_match('/java/i', $useragent)) {
            $browser = new JavaStandardLibrary($useragent, []);
        } elseif (preg_match('/(unister\-test|unistertesting|unister\-https\-test)/i', $useragent)) {
            $browser = new UnisterTesting($useragent, []);
        } else {
            $browser = new UnknownBrowser($useragent, []);
        }

        return $browser;
    }
}
