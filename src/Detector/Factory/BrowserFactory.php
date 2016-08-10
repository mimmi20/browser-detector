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
            return new RevIpSnfoSiteAnalyzer($useragent, []);
        } elseif (preg_match('/reddit pic scraper/i', $useragent)) {
            return new RedditPicScraper($useragent, []);
        } elseif (preg_match('/Mozilla crawl/', $useragent)) {
            return new MozillaCrawler($useragent, []);
        } elseif (preg_match('/^\[FBAN/i', $useragent)) {
            return new FacebookApp($useragent, []);
        } elseif (preg_match('/UCBrowserHD/', $useragent)) {
            return new UcBrowserHd($useragent, []);
        } elseif (preg_match('/(ucbrowser|uc browser|ucweb)/i', $useragent) && preg_match('/opera mini/i', $useragent)) {
            return new UcBrowser($useragent, []);
        } elseif (preg_match('/(opera mini|opios)/i', $useragent)) {
            return new OperaMini($useragent, []);
        } elseif (preg_match('/opera mobi/i', $useragent)
            || (preg_match('/(opera|opr)/i', $useragent) && preg_match('/(Android|MTK|MAUI|SAMSUNG|Windows CE|SymbOS)/', $useragent))
        ) {
            return new OperaMobile($useragent, []);
        } elseif (preg_match('/(ucbrowser|uc browser|ucweb)/i', $useragent)) {
            return new UcBrowser($useragent, []);
        } elseif (preg_match('/IC OpenGraph Crawler/', $useragent)) {
            return new IbmConnections($useragent, []);
        } elseif (preg_match('/coast/i', $useragent)) {
            return new OperaCoast($useragent, []);
        } elseif (preg_match('/(opera|opr)/i', $useragent)) {
            return new Opera($useragent, []);
        } elseif (preg_match('/iCabMobile/', $useragent)) {
            return new IcabMobile($useragent, []);
        } elseif (preg_match('/iCab/', $useragent)) {
            return new Icab($useragent, []);
        } elseif (preg_match('/HggH PhantomJS Screenshoter/', $useragent)) {
            return new HgghPhantomjsScreenshoter($useragent, []);
        } elseif (preg_match('/bl\.uk\_lddc\_bot/', $useragent)) {
            return new BlukLddcBot($useragent, []);
        } elseif (preg_match('/phantomas/', $useragent)) {
            return new Phantomas($useragent, []);
        } elseif (preg_match('/Seznam screenshot\-generator/', $useragent)) {
            return new SeznamScreenshotGenerator($useragent, []);
        } elseif (false !== strpos($useragent, 'PhantomJS')) {
            return new PhantomJs($useragent, []);
        } elseif (false !== strpos($useragent, 'YaBrowser')) {
            return new YaBrowser($useragent, []);
        } elseif (false !== strpos($useragent, 'Kamelio')) {
            return new KamelioApp($useragent, []);
        } elseif (false !== strpos($useragent, 'FBAV')) {
            return new FacebookApp($useragent, []);
        } elseif (false !== strpos($useragent, 'ACHEETAHI')) {
            return new CmBrowser($useragent, []);
        } elseif (preg_match('/flyflow/i', $useragent)) {
            return new FlyFlow($useragent, []);
        } elseif (false !== strpos($useragent, 'bdbrowser_i18n') || false !== strpos($useragent, 'baidubrowser')) {
            return new BaiduBrowser($useragent, []);
        } elseif (false !== strpos($useragent, 'bdbrowserhd_i18n')) {
            return new BaiduHdBrowser($useragent, []);
        } elseif (false !== strpos($useragent, 'bdbrowser_mini')) {
            return new BaiduMiniBrowser($useragent, []);
        } elseif (false !== strpos($useragent, 'Puffin')) {
            return new Puffin($useragent, []);
        } elseif (preg_match('/stagefright/', $useragent)) {
            return new Stagefright($useragent, []);
        } elseif (false !== strpos($useragent, 'SamsungBrowser')) {
            return new SamsungBrowser($useragent, []);
        } elseif (false !== strpos($useragent, 'Silk')) {
            return new Silk($useragent, []);
        } elseif (false !== strpos($useragent, 'coc_coc_browser')) {
            return new CocCocBrowser($useragent, []);
        } elseif (false !== strpos($useragent, 'NaverMatome')) {
            return new NaverMatome($useragent, []);
        } elseif (preg_match('/FlipboardProxy/', $useragent)) {
            return new FlipboardProxy($useragent, []);
        } elseif (false !== strpos($useragent, 'Flipboard')) {
            return new Flipboard($useragent, []);
        } elseif (false !== strpos($useragent, 'Seznam.cz')) {
            return new SeznamBrowser($useragent, []);
        } elseif (false !== strpos($useragent, 'Aviator')) {
            return new WhiteHatAviator($useragent, []);
        } elseif (preg_match('/NetFrontLifeBrowser/', $useragent)) {
            return new NetFrontLifeBrowser($useragent, []);
        } elseif (preg_match('/IceDragon/', $useragent)) {
            return new ComodoIceDragon($useragent, []);
        } elseif (false !== strpos($useragent, 'Dragon') && false === strpos($useragent, 'DragonFly')) {
            return new ComodoDragon($useragent, []);
        } elseif (false !== strpos($useragent, 'Beamrise')) {
            return new Beamrise($useragent, []);
        } elseif (false !== strpos($useragent, 'Diglo')) {
            return new Diglo($useragent, []);
        } elseif (false !== strpos($useragent, 'APUSBrowser')) {
            return new ApusBrowser($useragent, []);
        } elseif (false !== strpos($useragent, 'Chedot')) {
            return new Chedot($useragent, []);
        } elseif (false !== strpos($useragent, 'Qword')) {
            return new QwordBrowser($useragent, []);
        } elseif (false !== strpos($useragent, 'Iridium')) {
            return new Iridium($useragent, []);
        } elseif (preg_match('/avant/i', $useragent)) {
            return new Avant($useragent, []);
        } elseif (false !== strpos($useragent, 'MxNitro')) {
            return new MaxthonNitro($useragent, []);
        } elseif (preg_match('/(mxbrowser|maxthon|myie)/i', $useragent)) {
            return new Maxthon($useragent, []);
        } elseif (preg_match('/superbird/i', $useragent)) {
            return new SuperBird($useragent, []);
        } elseif (false !== strpos($useragent, 'TinyBrowser')) {
            return new TinyBrowser($useragent, []);
        } elseif (preg_match('/MicroMessenger/', $useragent)) {
            return new WeChatApp($useragent, []);
        } elseif (preg_match('/MQQBrowser\/Mini/', $useragent)) {
            return new QqBrowserMini($useragent, []);
        } elseif (preg_match('/MQQBrowser/', $useragent)) {
            return new QqBrowser($useragent, []);
        } elseif (preg_match('/pinterest/i', $useragent)) {
            return new PinterestApp($useragent, []);
        } elseif (preg_match('/baiduboxapp/', $useragent)) {
            return new BaiduBoxApp($useragent, []);
        } elseif (preg_match('/wkbrowser/', $useragent)) {
            return new WkBrowser($useragent, []);
        } elseif (preg_match('/Mb2345Browser/', $useragent)) {
            return new Browser2345($useragent, []);
        } elseif (false !== strpos($useragent, 'Chrome')
            && false !== strpos($useragent, 'Version')
            && 0 < strpos($useragent, 'Chrome')
        ) {
            return new AndroidWebView($useragent, []);
        } elseif (false !== strpos($useragent, 'Safari')
            && false !== strpos($useragent, 'Version')
            && false !== strpos($useragent, 'Tizen')
        ) {
            return new SamsungWebView($useragent, []);
        } elseif (preg_match('/cybeye/i', $useragent)) {
            return new CybEye($useragent, []);
        } elseif (preg_match('/RebelMouse/', $useragent)) {
            return new RebelMouse($useragent, []);
        } elseif (preg_match('/SeaMonkey/', $useragent)) {
            return new Seamonkey($useragent, []);
        } elseif (preg_match('/Jobboerse/', $useragent)) {
            return new JobBoerseBot($useragent, []);
        } elseif (preg_match('/Navigator/', $useragent)) {
            return new NetscapeNavigator($useragent, []);
        } elseif (preg_match('/firefox/i', $useragent) && preg_match('/anonym/i', $useragent)) {
            return new Firefox($useragent, []);
        } elseif (preg_match('/trident/i', $useragent) && preg_match('/anonym/i', $useragent)) {
            return new MicrosoftInternetExplorer($useragent, []);
        } elseif (preg_match('/Windows\-RSS\-Platform/', $useragent)) {
            return new WindowsRssPlatform($useragent, []);
        } elseif (preg_match('/MarketwireBot/', $useragent)) {
            return new MarketwireBot($useragent, []);
        } elseif (preg_match('/GoogleToolbar/', $useragent)) {
            return new GoogleToolbar($useragent, []);
        } elseif (preg_match('/netscape/i', $useragent) && preg_match('/msie/i', $useragent)) {
            return new Netscape($useragent, []);
        } elseif (preg_match('/LSSRocketCrawler/', $useragent)) {
            return new LightspeedSystemsRocketCrawler($useragent, []);
        } elseif (preg_match('/lightspeedsystems/i', $useragent)) {
            return new LightspeedSystemsCrawler($useragent, []);
        } elseif (preg_match('/SL Commerce Client/', $useragent)) {
            return new SecondLiveCommerceClient($useragent, []);
        } elseif (preg_match('/(IEMobile|WPDesktop|ZuneWP7|XBLWP7)/', $useragent)) {
            return new MicrosoftMobileExplorer($useragent, []);
        } elseif (preg_match('/BingPreview/', $useragent)) {
            return new BingPreview($useragent, []);
        } elseif (preg_match('/360Spider/', $useragent)) {
            return new Bot360($useragent, []);
        } elseif (preg_match('/Outlook\-Express/', $useragent)) {
            return new WindowsLiveMail($useragent, []);
        } elseif (preg_match('/Outlook/', $useragent)) {
            return new MicrosoftOutlook($useragent, []);
        } elseif (preg_match('/microsoft office mobile/i', $useragent)) {
            return new MicrosoftOffice($useragent, []);
        } elseif (preg_match('/MSOffice/', $useragent)) {
            return new MicrosoftOffice($useragent, []);
        } elseif (preg_match('/Microsoft Office Protocol Discovery/', $useragent)) {
            return new MicrosoftOfficeProtocolDiscovery($useragent, []);
        } elseif (preg_match('/excel/i', $useragent)) {
            return new MicrosoftExcel($useragent, []);
        } elseif (preg_match('/powerpoint/i', $useragent)) {
            return new MicrosoftPowerPoint($useragent, []);
        } elseif (preg_match('/WordPress/', $useragent)) {
            return new WordPress($useragent, []);
        } elseif (preg_match('/Word/', $useragent)) {
            return new MicrosoftWord($useragent, []);
        } elseif (preg_match('/OneNote/', $useragent)) {
            return new MicrosoftOneNote($useragent, []);
        } elseif (preg_match('/Visio/', $useragent)) {
            return new MicrosoftVisio($useragent, []);
        } elseif (preg_match('/Access/', $useragent)) {
            return new MicrosoftAccess($useragent, []);
        } elseif (preg_match('/Lync/', $useragent)) {
            return new MicrosoftLync($useragent, []);
        } elseif (preg_match('/Office SyncProc/', $useragent)) {
            return new MicrosoftOfficeSyncProc($useragent, []);
        } elseif (preg_match('/Office Upload Center/', $useragent)) {
            return new MicrosoftOfficeUploadCenter($useragent, []);
        } elseif (preg_match('/frontpage/i', $useragent)) {
            return new MicrosoftFrontPage($useragent, []);
        } elseif (preg_match('/microsoft office/i', $useragent)) {
            return new MicrosoftOffice($useragent, []);
        } elseif (preg_match('/Crazy Browser/', $useragent)) {
            return new CrazyBrowser($useragent, []);
        } elseif (preg_match('/Deepnet Explorer/', $useragent)) {
            return new DeepnetExplorer($useragent, []);
        } elseif (preg_match('/kkman/i', $useragent)) {
            return new Kkman($useragent, []);
        } elseif (preg_match('/Lunascape/', $useragent)) {
            return new Lunascape($useragent, []);
        } elseif (preg_match('/Sleipnir/', $useragent)) {
            return new Sleipnir($useragent, []);
        } elseif (preg_match('/Smartsite HTTPClient/', $useragent)) {
            return new SmartsiteHttpClient($useragent, []);
        } elseif (preg_match('/GomezAgent/', $useragent)) {
            return new GomezSiteMonitor($useragent, []);
        } elseif (preg_match('/Mozilla\/5\.0.*\(.*Trident\/8\.0.*rv\:\d+\).*/', $useragent)
            || preg_match('/Mozilla\/5\.0.*\(.*Trident\/7\.0.*\) like Gecko.*/', $useragent)
            || preg_match('/Mozilla\/5\.0.*\(.*MSIE 10\.0.*Trident\/(4|5|6|7|8)\.0.*/', $useragent)
            || preg_match('/Mozilla\/(4|5)\.0.*\(.*MSIE (9|8|7|6)\.0.*/', $useragent)
            || preg_match('/Mozilla\/(4|5)\.0.*\(.*MSIE (5|4)\.\d+.*/', $useragent)
            || preg_match('/Mozilla\/\d\.\d+.*\(.*MSIE (3|2|1)\.\d+.*/', $useragent)
        ) {
            return new MicrosoftInternetExplorer($useragent, []);
        } elseif (false !== strpos($useragent, 'Chromium')) {
            return new Chromium($useragent, []);
        } elseif (false !== strpos($useragent, 'Iron')) {
            return new Iron($useragent, []);
        } elseif (preg_match('/midori/i', $useragent)) {
            return new Midori($useragent, []);
        } elseif (preg_match('/Google Page Speed Insights/', $useragent)) {
            return new GooglePageSpeedInsights($useragent, []);
        } elseif (preg_match('/(web\/snippet)/', $useragent)) {
            return new GoogleWebSnippet($useragent, []);
        } elseif (preg_match('/(googlebot\-mobile)/i', $useragent)) {
            return new GooglebotMobileBot($useragent, []);
        } elseif (preg_match('/Google Wireless Transcoder/', $useragent)) {
            return new GoogleWirelessTranscoder($useragent, []);
        } elseif (preg_match('/Locubot/', $useragent)) {
            return new Locubot($useragent, []);
        } elseif (preg_match('/(com\.google\.GooglePlus)/i', $useragent)) {
            return new GooglePlus($useragent, []);
        } elseif (preg_match('/Google\-HTTP\-Java\-Client/', $useragent)) {
            return new GoogleHttpClientLibraryForJava($useragent, []);
        } elseif (preg_match('/acapbot/i', $useragent)) {
            return new Acapbot($useragent, []);
        } elseif (preg_match('/googlebot\-image/i', $useragent)) {
            return new GoogleImageSearch($useragent, []);
        } elseif (preg_match('/googlebot/i', $useragent)) {
            return new Googlebot($useragent, []);
        } elseif (preg_match('/^GOOG$/', $useragent)) {
            return new Googlebot($useragent, []);
        } elseif (preg_match('/viera/i', $useragent)) {
            return new SmartViera($useragent, []);
        } elseif (preg_match('/Nichrome/', $useragent)) {
            return new Nichrome($useragent, []);
        } elseif (preg_match('/Kinza/', $useragent)) {
            return new Kinza($useragent, []);
        } elseif (preg_match('/Google Keyword Suggestion/', $useragent)) {
            return new GoogleKeywordSuggestion($useragent, []);
        } elseif (preg_match('/Google Web Preview/', $useragent)) {
            return new GoogleWebPreview($useragent, []);
        } elseif (preg_match('/Google-Adwords-DisplayAds-WebRender/', $useragent)) {
            return new GoogleAdwordsDisplayAdsWebRender($useragent, []);
        } elseif (preg_match('/HubSpot Webcrawler/', $useragent)) {
            return new HubSpotWebcrawler($useragent, []);
        } elseif (preg_match('/RockMelt/', $useragent)) {
            return new Rockmelt($useragent, []);
        } elseif (preg_match('/ SE /', $useragent)) {
            return new SogouExplorer($useragent, []);
        } elseif (preg_match('/ArchiveBot/', $useragent)) {
            return new ArchiveBot($useragent, []);
        } elseif (preg_match('/Edge/', $useragent) && null !== $platform && 'Windows Phone OS' === $platform->getName()) {
            return new MicrosoftEdgeMobile($useragent, []);
        } elseif (preg_match('/Edge/', $useragent)) {
            return new MicrosoftEdge($useragent, []);
        } elseif (preg_match('/diffbot/i', $useragent)) {
            return new Diffbot($useragent, []);
        } elseif (preg_match('/vivaldi/i', $useragent)) {
            return new Vivaldi($useragent, []);
        } elseif (preg_match('/LBBROWSER/', $useragent)) {
            return new Liebao($useragent, []);
        } elseif (preg_match('/Amigo/', $useragent)) {
            return new Amigo($useragent, []);
        } elseif (preg_match('/CoolNovoChromePlus/', $useragent)) {
            return new CoolNovoChromePlus($useragent, []);
        } elseif (preg_match('/CoolNovo/', $useragent)) {
            return new CoolNovo($useragent, []);
        } elseif (preg_match('/Kenshoo/', $useragent)) {
            return new Kenshoo($useragent, []);
        } elseif (preg_match('/Bowser/', $useragent)) {
            return new Bowser($useragent, []);
        } elseif (preg_match('/360SE/', $useragent)) {
            return new SecureBrowser360($useragent, []);
        } elseif (preg_match('/360EE/', $useragent)) {
            return new SpeedBrowser360($useragent, []);
        } elseif (preg_match('/ASW/', $useragent)) {
            return new AvastSafeZone($useragent, []);
        } elseif (preg_match('/Wire/', $useragent)) {
            return new WireApp($useragent, []);
        } elseif (preg_match('/chrome\/(\d+)\.(\d+)/i', $useragent, $matches)
            && isset($matches[1])
            && isset($matches[2])
            && $matches[1] >= 1
            && $matches[2] > 0
            && $matches[2] <= 10
        ) {
            return new ComodoDragon($useragent, []);
        } elseif (preg_match('/Flock/', $useragent)) {
            return new Flock($useragent, []);
        } elseif (preg_match('/Bromium Safari/', $useragent)) {
            return new Vsentry($useragent, []);
        } elseif (preg_match('/(chrome|crmo|crios)/i', $useragent)) {
            return new Chrome($useragent, []);
        } elseif (preg_match('/(dolphin http client)/i', $useragent)) {
            return new DolphinSmalltalkHttpClient($useragent, []);
        } elseif (preg_match('/(dolphin|dolfin)/i', $useragent)) {
            return new Dolfin($useragent, []);
        } elseif (preg_match('/Arora/', $useragent)) {
            return new Arora($useragent, []);
        } elseif (preg_match('/com\.douban\.group/i', $useragent)) {
            return new DoubanApp($useragent, []);
        } elseif (preg_match('/ovibrowser/i', $useragent)) {
            return new NokiaProxyBrowser($useragent, []);
        } elseif (preg_match('/MiuiBrowser/i', $useragent)) {
            return new MiuiBrowser($useragent, []);
        } elseif (preg_match('/ibrowser/i', $useragent)) {
            return new IBrowser($useragent, []);
        } elseif (preg_match('/OneBrowser/', $useragent)) {
            return new OneBrowser($useragent, []);
        } elseif (preg_match('/Baiduspider\-image/', $useragent)) {
            return new BaiduImageSearch($useragent, []);
        } elseif (preg_match('/http:\/\/www\.baidu\.com\/search/', $useragent)) {
            return new BaiduMobileSearch($useragent, []);
        } elseif (preg_match('/(yjapp|yjtop)/i', $useragent)) {
            return new YahooApp($useragent, []);
        } elseif (preg_match('/(linux; u; android|linux; android)/i', $useragent) && preg_match('/version/i', $useragent)) {
            return new AndroidWebkit($useragent, []);
        } elseif (preg_match('/safari/i', $useragent) && null !== $platform && 'Android' === $platform->getName()) {
            return new AndroidWebkit($useragent, []);
        } elseif (preg_match('/Browser\/AppleWebKit/', $useragent)) {
            return new AndroidWebkit($useragent, []);
        } elseif (preg_match('/Android\/[\d\.]+ release/', $useragent)) {
            return new AndroidWebkit($useragent, []);
        } elseif (false !== strpos($useragent, 'BlackBerry') && false !== strpos($useragent, 'Version')) {
            return new Blackberry($useragent, []);
        } elseif (preg_match('/(webOS|wOSBrowser|wOSSystem)/', $useragent)) {
            return new WebkitWebos($useragent, []);
        } elseif (preg_match('/OmniWeb/', $useragent)) {
            return new Omniweb($useragent, []);
        } elseif (preg_match('/Windows Phone Search/', $useragent)) {
            return new WindowsPhoneSearch($useragent, []);
        } elseif (preg_match('/Windows\-Update\-Agent/', $useragent)) {
            return new WindowsUpdateAgent($useragent, []);
        } elseif (preg_match('/nokia/i', $useragent)) {
            return new NokiaBrowser($useragent, []);
        } elseif (preg_match('/twitter for i/i', $useragent)) {
            return new TwitterApp($useragent, []);
        } elseif (preg_match('/twitterbot/i', $useragent)) {
            return new Twitterbot($useragent, []);
        } elseif (preg_match('/GSA/', $useragent)) {
            return new GoogleApp($useragent, []);
        } elseif (preg_match('/QtCarBrowser/', $useragent)) {
            return new ModelsBrowser($useragent, []);
        } elseif (preg_match('/Qt/', $useragent)) {
            return new Qt($useragent, []);
        } elseif (preg_match('/Instagram/', $useragent)) {
            return new InstagramApp($useragent, []);
        } elseif (preg_match('/WebClip/', $useragent)) {
            return new WebClip($useragent, []);
        } elseif (preg_match('/Mercury/', $useragent)) {
            return new Mercury($useragent, []);
        } elseif (preg_match('/MacAppStore/', $useragent)) {
            return new MacAppStore($useragent, []);
        } elseif (preg_match('/AppStore/', $useragent)) {
            return new AppleAppStoreApp($useragent, []);
        } elseif (preg_match('/Webglance/', $useragent)) {
            return new WebGlance($useragent, []);
        } elseif (preg_match('/YHOO\_Search\_App/', $useragent)) {
            return new YahooMobileApp($useragent, []);
        } elseif (preg_match('/NewsBlur Feed Fetcher/', $useragent)) {
            return new NewsBlurFeedFetcher($useragent, []);
        } elseif (preg_match('/AppleCoreMedia/', $useragent)) {
            return new AppleCoreMedia($useragent, []);
        } elseif (preg_match('/dataaccessd/', $useragent)) {
            return new IosDataaccessd($useragent, []);
        } elseif (preg_match('/MailChimp/', $useragent)) {
            return new MailChimp($useragent, []);
        } elseif (preg_match('/MailBar/', $useragent)) {
            return new MailBar($useragent, []);
        } elseif (preg_match('/^Mail/', $useragent)) {
            return new AppleMail($useragent, []);
        } elseif (preg_match('/^Mozilla\/5\.0.*\(.*(CPU iPhone OS|CPU OS) \d+(_|\.)\d+.* like Mac OS X.*\) AppleWebKit.* \(KHTML, like Gecko\)$/', $useragent)) {
            return new AppleMail($useragent, []);
        } elseif (preg_match('/^Mozilla\/5\.0 \(Macintosh; Intel Mac OS X.*\) AppleWebKit.* \(KHTML, like Gecko\)$/', $useragent)) {
            return new AppleMail($useragent, []);
        } elseif (preg_match('/^Mozilla\/5\.0 \(Windows.*\) AppleWebKit.* \(KHTML, like Gecko\)$/', $useragent)) {
            return new AppleMail($useragent, []);
        } elseif (preg_match('/msnbot\-media/i', $useragent)) {
            return new MsnBotMedia($useragent, []);
        } elseif (preg_match('/adidxbot/i', $useragent)) {
            return new Adidxbot($useragent, []);
        } elseif (preg_match('/msnbot/i', $useragent)) {
            return new Bingbot($useragent, []);
        } elseif (preg_match('/(backberry|bb10)/i', $useragent)) {
            return new Blackberry($useragent, []);
        } elseif (preg_match('/WeTab\-Browser/', $useragent)) {
            return new WeTabBrowser($useragent, []);
        } elseif (preg_match('/profiller/', $useragent)) {
            return new Profiller($useragent, []);
        } elseif (preg_match('/(wkhtmltopdf)/i', $useragent)) {
            return new WkHtmltopdf($useragent, []);
        } elseif (preg_match('/(wkhtmltoimage)/i', $useragent)) {
            return new WkHtmltoImage($useragent, []);
        } elseif (preg_match('/(wp\-iphone|wp\-android)/', $useragent)) {
            return new WordPressApp($useragent, []);
        } elseif (preg_match('/OktaMobile/', $useragent)) {
            return new OktaMobileApp($useragent, []);
        } elseif (preg_match('/kmail2/', $useragent)) {
            return new Kmail2($useragent, []);
        } elseif (preg_match('/eb\-iphone/', $useragent)) {
            return new EbApp($useragent, []);
        } elseif (preg_match('/ElmediaPlayer/', $useragent)) {
            return new ElmediaPlayer($useragent, []);
        } elseif (preg_match('/Schoolwires/', $useragent)) {
            return new SchoolwiresApp($useragent, []);
        } elseif (preg_match('/Dreamweaver/', $useragent)) {
            return new Dreamweaver($useragent, []);
        } elseif (preg_match('/akregator/', $useragent)) {
            return new Akregator($useragent, []);
        } elseif (preg_match('/Installatron/', $useragent)) {
            return new Installatron($useragent, []);
        } elseif (preg_match('/Quora Link Preview/', $useragent)) {
            return new QuoraLinkPreviewBot($useragent, []);
        } elseif (preg_match('/Quora/', $useragent)) {
            return new QuoraApp($useragent, []);
        } elseif (preg_match('/Rocky ChatWork Mobile/', $useragent)) {
            return new RockyChatWorkMobile($useragent, []);
        } elseif (preg_match('/AdsBot\-Google\-Mobile/', $useragent)) {
            return new GoogleAdsbotMobile($useragent, []);
        } elseif (preg_match('/epiphany/i', $useragent)) {
            return new Epiphany($useragent, []);
        } elseif (preg_match('/rekonq/', $useragent)) {
            return new Rekonq($useragent, []);
        } elseif (preg_match('/Skyfire/', $useragent)) {
            return new Skyfire($useragent, []);
        } elseif (preg_match('/FlixsteriOS/', $useragent)) {
            return new FlixsterApp($useragent, []);
        } elseif (preg_match('/(adbeat\_bot|adbeat\.com)/', $useragent)) {
            return new AdbeatBot($useragent, []);
        } elseif (preg_match('/(SecondLife|Second Life)/', $useragent)) {
            return new SecondLiveClient($useragent, []);
        } elseif (preg_match('/(Salesforce1|SalesforceTouchContainer)/', $useragent)) {
            return new SalesForceApp($useragent, []);
        } elseif (preg_match('/(nagios\-plugins|check\_http)/', $useragent)) {
            return new Nagios($useragent, []);
        } elseif (preg_match('/bingbot/i', $useragent)) {
            return new Bingbot($useragent, []);
        } elseif (preg_match('/Mediapartners\-Google/', $useragent)) {
            return new GoogleAdSenseBot($useragent, []);
        } elseif (preg_match('/SMTBot/', $useragent)) {
            return new SmtBot($useragent, []);
        } elseif (preg_match('/domain\.com/', $useragent)) {
            return new PagePeekerScreenshotMaker($useragent, []);
        } elseif (preg_match('/PagePeeker/', $useragent)) {
            return new PagePeeker($useragent, []);
        } elseif (preg_match('/DiigoBrowser/', $useragent)) {
            return new DiigoBrowser($useragent, []);
        } elseif (preg_match('/kontact/', $useragent)) {
            return new Kontact($useragent, []);
        } elseif (preg_match('/QupZilla/', $useragent)) {
            return new QupZilla($useragent, []);
        } elseif (preg_match('/FxiOS/', $useragent)) {
            return new FirefoxIos($useragent, []);
        } elseif (preg_match('/qutebrowser/', $useragent)) {
            return new QuteBrowser($useragent, []);
        } elseif (preg_match('/Otter/', $useragent)) {
            return new Otter($useragent, []);
        } elseif (preg_match('/PaleMoon/', $useragent)) {
            return new Palemoon($useragent, []);
        } elseif (preg_match('/slurp/i', $useragent)) {
            return new YahooSlurp($useragent, []);
        } elseif (preg_match('/applebot/i', $useragent)) {
            return new Applebot($useragent, []);
        } elseif (preg_match('/SoundCloud/', $useragent)) {
            return new SoundCloudApp($useragent, []);
        } elseif (preg_match('/Rival IQ/', $useragent)) {
            return new RivalIqBot($useragent, []);
        } elseif (preg_match('/Evernote Clip Resolver/', $useragent)) {
            return new EvernoteClipResolver($useragent, []);
        } elseif (preg_match('/Evernote/', $useragent)) {
            return new EvernoteApp($useragent, []);
        } elseif (preg_match('/Fluid/', $useragent)) {
            return new Fluid($useragent, []);
        } elseif (preg_match('/safari/i', $useragent)) {
            return new Safari($useragent, []);
        } elseif (preg_match('/^Mozilla\/(4|5)\.0 \(Macintosh; .* Mac OS X .*\) AppleWebKit\/.* \(KHTML, like Gecko\) Version\/[\d\.]+$/i', $useragent)) {
            return new Safari($useragent, []);
        } elseif (preg_match('/TWCAN\/SportsNet/', $useragent)) {
            return new TwcSportsNet($useragent, []);
        } elseif (preg_match('/AdobeAIR/', $useragent)) {
            return new AdobeAIR($useragent, []);
        } elseif (preg_match('/(easouspider)/i', $useragent)) {
            return new EasouSpider($useragent, []);
        } elseif (preg_match('/^Mozilla\/5\.0.*\((iPhone|iPad|iPod).*\).*AppleWebKit\/.*\(.*KHTML, like Gecko.*\).*Mobile.*/i', $useragent)) {
            return new MobileSafariUiWebView($useragent, []);
        } elseif (preg_match('/waterfox/i', $useragent)) {
            return new WaterFox($useragent, []);
        } elseif (preg_match('/Thunderbird/', $useragent)) {
            return new Thunderbird($useragent, []);
        } elseif (preg_match('/Fennec/', $useragent)) {
            return new Fennec($useragent, []);
        } elseif (preg_match('/myibrow/', $useragent)) {
            return new MyInternetBrowser($useragent, []);
        } elseif (preg_match('/Daumoa/', $useragent)) {
            return new Daumoa($useragent, []);
        } elseif (preg_match('/PaleMoon/', $useragent)) {
            return new Palemoon($useragent, []);
        } elseif (preg_match('/iceweasel/i', $useragent)) {
            return new Iceweasel($useragent, []);
        } elseif (preg_match('/icecat/i', $useragent)) {
            return new IceCat($useragent, []);
        } elseif (preg_match('/iceape/i', $useragent)) {
            return new Iceape($useragent, []);
        } elseif (preg_match('/galeon/i', $useragent)) {
            return new Galeon($useragent, []);
        } elseif (preg_match('/SurveyBot/', $useragent)) {
            return new SurveyBot($useragent, []);
        } elseif (preg_match('/aggregator\:Spinn3r/', $useragent)) {
            return new Spinn3rRssAggregator($useragent, []);
        } elseif (preg_match('/TweetmemeBot/', $useragent)) {
            return new TweetmemeBot($useragent, []);
        } elseif (preg_match('/Butterfly/', $useragent)) {
            return new ButterflyRobot($useragent, []);
        } elseif (preg_match('/James BOT/', $useragent)) {
            return new JamesBot($useragent, []);
        } elseif (preg_match('/MSIE or Firefox mutant; not on Windows server/', $useragent)) {
            return new Daumoa($useragent, []);
        } elseif (preg_match('/SailfishBrowser/', $useragent)) {
            return new SailfishBrowser($useragent, []);
        } elseif (preg_match('/KcB/', $useragent)) {
            return new UnknownBrowser($useragent, []);
        } elseif (preg_match('/kazehakase/i', $useragent)) {
            return new Kazehakase($useragent, []);
        } elseif (preg_match('/cometbird/i', $useragent)) {
            return new CometBird($useragent, []);
        } elseif (preg_match('/Camino/', $useragent)) {
            return new Camino($useragent, []);
        } elseif (preg_match('/SlimerJS/', $useragent)) {
            return new SlimerJs($useragent, []);
        } elseif (preg_match('/MultiZilla/', $useragent)) {
            return new MultiZilla($useragent, []);
        } elseif (preg_match('/Minimo/', $useragent)) {
            return new Minimo($useragent, []);
        } elseif (preg_match('/MicroB/', $useragent)) {
            return new MicroB($useragent, []);
        } elseif (preg_match('/firefox/i', $useragent)
            && !preg_match('/gecko/i', $useragent)
            && preg_match('/anonymized/i', $useragent)
        ) {
            return new Firefox($useragent, []);
        } elseif (preg_match('/(firefox|minefield|shiretoko|bonecho|namoroka)/i', $useragent)) {
            return new Firefox($useragent, []);
        } elseif (preg_match('/gvfs/', $useragent)) {
            return new Gvfs($useragent, []);
        } elseif (preg_match('/luakit/', $useragent)) {
            return new Luakit($useragent, []);
        } elseif (preg_match('/playstation 3/i', $useragent)) {
            return new NetFront($useragent, []);
        } elseif (preg_match('/sistrix/i', $useragent)) {
            return new Sistrix($useragent, []);
        } elseif (preg_match('/ezooms/i', $useragent)) {
            return new Ezooms($useragent, []);
        } elseif (preg_match('/grapefx/i', $useragent)) {
            return new GrapeFx($useragent, []);
        } elseif (preg_match('/grapeshotcrawler/i', $useragent)) {
            return new GrapeshotCrawler($useragent, []);
        } elseif (preg_match('/(mail\.ru)/i', $useragent)) {
            return new MailRu($useragent, []);
        } elseif (preg_match('/(proximic)/i', $useragent)) {
            return new Proximic($useragent, []);
        } elseif (preg_match('/(polaris)/i', $useragent)) {
            return new Polaris($useragent, []);
        } elseif (preg_match('/(another web mining tool|awmt)/i', $useragent)) {
            return new AnotherWebMiningTool($useragent, []);
        } elseif (preg_match('/(wbsearchbot|wbsrch)/i', $useragent)) {
            return new WbSearchBot($useragent, []);
        } elseif (preg_match('/(konqueror)/i', $useragent)) {
            return new Konqueror($useragent, []);
        } elseif (preg_match('/(typo3\-linkvalidator)/i', $useragent)) {
            return new Typo3Linkvalidator($useragent, []);
        } elseif (preg_match('/feeddlerrss/i', $useragent)) {
            return new FeeddlerRssReader($useragent, []);
        } elseif (preg_match('/^mozilla\/5\.0 \((iphone|ipad|ipod).*CPU like Mac OS X.*\) AppleWebKit\/\d+/i', $useragent)) {
            return new Safari($useragent, []);
        } elseif (preg_match('/(ios|iphone|ipad|ipod)/i', $useragent)) {
            return new MobileSafariUiWebView($useragent, []);
        } elseif (preg_match('/paperlibot/i', $useragent)) {
            return new PaperLiBot($useragent, []);
        } elseif (preg_match('/spbot/i', $useragent)) {
            return new Seoprofiler($useragent, []);
        } elseif (preg_match('/dotbot/i', $useragent)) {
            return new DotBot($useragent, []);
        } elseif (preg_match('/(google\-structureddatatestingtool|Google\-structured\-data\-testing\-tool)/i', $useragent)) {
            return new GoogleStructuredDataTestingTool($useragent, []);
        } elseif (preg_match('/webmastercoffee/i', $useragent)) {
            return new WebmasterCoffee($useragent, []);
        } elseif (preg_match('/ahrefs/i', $useragent)) {
            return new AhrefsBot($useragent, []);
        } elseif (preg_match('/apercite/i', $useragent)) {
            return new Apercite($useragent, []);
        } elseif (preg_match('/woobot/', $useragent)) {
            return new WooRank($useragent, []);
        } elseif (preg_match('/Blekkobot/', $useragent)) {
            return new BlekkoBot($useragent, []);
        } elseif (preg_match('/PagesInventory/', $useragent)) {
            return new PagesInventoryBot($useragent, []);
        } elseif (preg_match('/Slackbot\-LinkExpanding/', $useragent)) {
            return new SlackbotLinkExpanding($useragent, []);
        } elseif (preg_match('/Slackbot/', $useragent)) {
            return new Slackbot($useragent, []);
        } elseif (preg_match('/SEOkicks\-Robot/', $useragent)) {
            return new Seokicks($useragent, []);
        } elseif (preg_match('/Exabot/', $useragent)) {
            return new Exabot($useragent, []);
        } elseif (preg_match('/DomainSCAN/', $useragent)) {
            return new DomainScanServerMonitoring($useragent, []);
        } elseif (preg_match('/JobRoboter/', $useragent)) {
            return new JobRoboter($useragent, []);
        } elseif (preg_match('/AcoonBot/', $useragent)) {
            return new AcoonBot($useragent, []);
        } elseif (preg_match('/woriobot/', $useragent)) {
            return new Woriobot($useragent, []);
        } elseif (preg_match('/MonoBot/', $useragent)) {
            return new MonoBot($useragent, []);
        } elseif (preg_match('/DomainSigmaCrawler/', $useragent)) {
            return new DomainSigmaCrawler($useragent, []);
        } elseif (preg_match('/bnf\.fr\_bot/', $useragent)) {
            return new BnfFrBot($useragent, []);
        } elseif (preg_match('/CrawlRobot/', $useragent)) {
            return new CrawlRobot($useragent, []);
        } elseif (preg_match('/AddThis\.com robot/', $useragent)) {
            return new AddThisRobot($useragent, []);
        } elseif (preg_match('/(Yeti|naver\.com\/robots)/', $useragent)) {
            return new NaverBot($useragent, []);
        } elseif (preg_match('/^robots$/', $useragent)) {
            return new TestCrawler($useragent, []);
        } elseif (preg_match('/DeuSu/', $useragent)) {
            return new WerbefreieDeutscheSuchmaschine($useragent, []);
        } elseif (preg_match('/obot/i', $useragent)) {
            return new Obot($useragent, []);
        } elseif (preg_match('/ZumBot/', $useragent)) {
            return new ZumBot($useragent, []);
        } elseif (preg_match('/(umbot)/i', $useragent)) {
            return new UmBot($useragent, []);
        } elseif (preg_match('/(picmole)/i', $useragent)) {
            return new PicmoleBot($useragent, []);
        } elseif (preg_match('/(zollard)/i', $useragent)) {
            return new ZollardWorm($useragent, []);
        } elseif (preg_match('/(fhscan core)/i', $useragent)) {
            return new FhscanCore($useragent, []);
        } elseif (preg_match('/nbot/i', $useragent)) {
            return new Nbot($useragent, []);
        } elseif (preg_match('/(loadtimebot)/i', $useragent)) {
            return new LoadTimeBot($useragent, []);
        } elseif (preg_match('/(scrubby)/i', $useragent)) {
            return new Scrubby($useragent, []);
        } elseif (preg_match('/(squzer)/i', $useragent)) {
            return new Squzer($useragent, []);
        } elseif (preg_match('/PiplBot/', $useragent)) {
            return new PiplBot($useragent, []);
        } elseif (preg_match('/EveryoneSocialBot/', $useragent)) {
            return new EveryoneSocialBot($useragent, []);
        } elseif (preg_match('/AOLbot/', $useragent)) {
            return new AolBot($useragent, []);
        } elseif (preg_match('/GLBot/', $useragent)) {
            return new GlBot($useragent, []);
        } elseif (preg_match('/(lbot)/i', $useragent)) {
            return new Lbot($useragent, []);
        } elseif (preg_match('/(blexbot)/i', $useragent)) {
            return new BlexBot($useragent, []);
        } elseif (preg_match('/(socialradarbot)/i', $useragent)) {
            return new Socialradarbot($useragent, []);
        } elseif (preg_match('/(synapse)/i', $useragent)) {
            return new ApacheSynapse($useragent, []);
        } elseif (preg_match('/(linkdexbot)/i', $useragent)) {
            return new LinkdexBot($useragent, []);
        } elseif (preg_match('/(coccoc)/i', $useragent)) {
            return new CocCocBot($useragent, []);
        } elseif (preg_match('/(siteexplorer)/i', $useragent)) {
            return new SiteExplorer($useragent, []);
        } elseif (preg_match('/(semrushbot)/i', $useragent)) {
            return new SemrushBot($useragent, []);
        } elseif (preg_match('/(istellabot)/i', $useragent)) {
            return new IstellaBot($useragent, []);
        } elseif (preg_match('/(meanpathbot)/i', $useragent)) {
            return new MeanpathBot($useragent, []);
        } elseif (preg_match('/(XML Sitemaps Generator)/', $useragent)) {
            return new XmlSitemapsGenerator($useragent, []);
        } elseif (preg_match('/SeznamBot/', $useragent)) {
            return new SeznamBot($useragent, []);
        } elseif (preg_match('/URLAppendBot/', $useragent)) {
            return new UrlAppendBot($useragent, []);
        } elseif (preg_match('/NetSeer crawler/', $useragent)) {
            return new NetseerCrawler($useragent, []);
        } elseif (preg_match('/SeznamBot/', $useragent)) {
            return new SeznamBot($useragent, []);
        } elseif (preg_match('/Add Catalog/', $useragent)) {
            return new AddCatalog($useragent, []);
        } elseif (preg_match('/Moreover/', $useragent)) {
            return new Moreover($useragent, []);
        } elseif (preg_match('/LinkpadBot/', $useragent)) {
            return new LinkpadBot($useragent, []);
        } elseif (preg_match('/Lipperhey SEO Service/', $useragent)) {
            return new LipperheySeoService($useragent, []);
        } elseif (preg_match('/Blog Search/', $useragent)) {
            return new BlogSearch($useragent, []);
        } elseif (preg_match('/Qualidator\.com Bot/', $useragent)) {
            return new QualidatorBot($useragent, []);
        } elseif (preg_match('/fr\-crawler/', $useragent)) {
            return new FrCrawler($useragent, []);
        } elseif (preg_match('/ca\-crawler/', $useragent)) {
            return new CaCrawler($useragent, []);
        } elseif (preg_match('/Website Thumbnail Generator/', $useragent)) {
            return new WebsiteThumbnailGenerator($useragent, []);
        } elseif (preg_match('/WebThumb/', $useragent)) {
            return new WebThumb($useragent, []);
        } elseif (preg_match('/KomodiaBot/', $useragent)) {
            return new KomodiaBot($useragent, []);
        } elseif (preg_match('/GroupHigh/', $useragent)) {
            return new GroupHighBot($useragent, []);
        } elseif (preg_match('/theoldreader/', $useragent)) {
            return new TheOldReader($useragent, []);
        } elseif (preg_match('/Google\-Site\-Verification/', $useragent)) {
            return new GoogleSiteVerification($useragent, []);
        } elseif (preg_match('/Prlog/', $useragent)) {
            return new Prlog($useragent, []);
        } elseif (preg_match('/CMS Crawler/', $useragent)) {
            return new CmsCrawler($useragent, []);
        } elseif (preg_match('/pmoz\.info ODP link checker/', $useragent)) {
            return new PmozinfoOdpLinkChecker($useragent, []);
        } elseif (preg_match('/Twingly Recon/', $useragent)) {
            return new TwinglyRecon($useragent, []);
        } elseif (preg_match('/Embedly/', $useragent)) {
            return new Embedly($useragent, []);
        } elseif (preg_match('/Alexabot/', $useragent)) {
            return new Alexabot($useragent, []);
        } elseif (preg_match('/alexa site audit/', $useragent)) {
            return new AlexaSiteAudit($useragent, []);
        } elseif (preg_match('/MJ12bot/', $useragent)) {
            return new Mj12bot($useragent, []);
        } elseif (preg_match('/HTTrack/', $useragent)) {
            return new Httrack($useragent, []);
        } elseif (preg_match('/UnisterBot/', $useragent)) {
            return new Unisterbot($useragent, []);
        } elseif (preg_match('/CareerBot/', $useragent)) {
            return new CareerBot($useragent, []);
        } elseif (preg_match('/80legs/i', $useragent)) {
            return new Bot80Legs($useragent, []);
        } elseif (preg_match('/wada\.vn/i', $useragent)) {
            return new WadavnSearchBot($useragent, []);
        } elseif (preg_match('/(NX|WiiU|Nintendo 3DS)/', $useragent)) {
            return new NetFrontNx($useragent, []);
        } elseif (preg_match('/(netfront|playstation 4)/i', $useragent)) {
            return new NetFront($useragent, []);
        } elseif (preg_match('/XoviBot/', $useragent)) {
            return new XoviBot($useragent, []);
        } elseif (preg_match('/007ac9 Crawler/', $useragent)) {
            return new Crawler007AC9($useragent, []);
        } elseif (preg_match('/200PleaseBot/', $useragent)) {
            return new Please200Bot($useragent, []);
        } elseif (preg_match('/Abonti/', $useragent)) {
            return new AbontiBot($useragent, []);
        } elseif (preg_match('/publiclibraryarchive/', $useragent)) {
            return new PublicLibraryArchive($useragent, []);
        } elseif (preg_match('/PAD\-bot/', $useragent)) {
            return new PadBot($useragent, []);
        } elseif (preg_match('/SoftListBot/', $useragent)) {
            return new SoftListBot($useragent, []);
        } elseif (preg_match('/sReleaseBot/', $useragent)) {
            return new SreleaseBot($useragent, []);
        } elseif (preg_match('/Vagabondo/', $useragent)) {
            return new Vagabondo($useragent, []);
        } elseif (preg_match('/special\_archiver/', $useragent)) {
            return new InternetArchiveSpecialArchiver($useragent, []);
        } elseif (preg_match('/Optimizer/', $useragent)) {
            return new OptimizerBot($useragent, []);
        } elseif (preg_match('/Sophora Linkchecker/', $useragent)) {
            return new SophoraLinkchecker($useragent, []);
        } elseif (preg_match('/SEOdiver/', $useragent)) {
            return new SeoDiver($useragent, []);
        } elseif (preg_match('/itsscan/', $useragent)) {
            return new ItsScan($useragent, []);
        } elseif (preg_match('/Google Desktop/', $useragent)) {
            return new GoogleDesktop($useragent, []);
        } elseif (preg_match('/Lotus\-Notes/', $useragent)) {
            return new LotusNotes($useragent, []);
        } elseif (preg_match('/AskPeterBot/', $useragent)) {
            return new AskPeterBot($useragent, []);
        } elseif (preg_match('/discoverybot/', $useragent)) {
            return new DiscoveryBot($useragent, []);
        } elseif (preg_match('/YandexBot/', $useragent)) {
            return new YandexBot($useragent, []);
        } elseif (preg_match('/MOSBookmarks/', $useragent) && preg_match('/Link Checker/', $useragent)) {
            return new MosBookmarksLinkChecker($useragent, []);
        } elseif (preg_match('/MOSBookmarks/', $useragent)) {
            return new MosBookmarks($useragent, []);
        } elseif (preg_match('/WebMasterAid/', $useragent)) {
            return new WebMasterAid($useragent, []);
        } elseif (preg_match('/AboutUsBot Johnny5/', $useragent)) {
            return new AboutUsBotJohnny5($useragent, []);
        } elseif (preg_match('/AboutUsBot/', $useragent)) {
            return new AboutUsBot($useragent, []);
        } elseif (preg_match('/semantic\-visions\.com crawler/', $useragent)) {
            return new SemanticVisionsCrawler($useragent, []);
        } elseif (preg_match('/waybackarchive\.org/', $useragent)) {
            return new WaybackArchive($useragent, []);
        } elseif (preg_match('/OpenVAS/', $useragent)) {
            return new OpenVulnerabilityAssessmentSystem($useragent, []);
        } elseif (preg_match('/MixrankBot/', $useragent)) {
            return new MixrankBot($useragent, []);
        } elseif (preg_match('/InfegyAtlas/', $useragent)) {
            return new InfegyAtlasBot($useragent, []);
        } elseif (preg_match('/MojeekBot/', $useragent)) {
            return new MojeekBot($useragent, []);
        } elseif (preg_match('/memorybot/i', $useragent)) {
            return new MemoryBot($useragent, []);
        } elseif (preg_match('/DomainAppender/', $useragent)) {
            return new DomainAppenderBot($useragent, []);
        } elseif (preg_match('/GIDBot/', $useragent)) {
            return new GidBot($useragent, []);
        } elseif (preg_match('/DBot/', $useragent)) {
            return new Dbot($useragent, []);
        } elseif (preg_match('/PWBot/', $useragent)) {
            return new PwBot($useragent, []);
        } elseif (preg_match('/\+5Bot/', $useragent)) {
            return new Plus5Bot($useragent, []);
        } elseif (preg_match('/WASALive\-Bot/', $useragent)) {
            return new WasaLiveBot($useragent, []);
        } elseif (preg_match('/OpenHoseBot/', $useragent)) {
            return new OpenHoseBot($useragent, []);
        } elseif (preg_match('/URLfilterDB\-crawler/', $useragent)) {
            return new UrlfilterDbCrawler($useragent, []);
        } elseif (preg_match('/metager2\-verification\-bot/', $useragent)) {
            return new Metager2VerificationBot($useragent, []);
        } elseif (preg_match('/Powermarks/', $useragent)) {
            return new Powermarks($useragent, []);
        } elseif (preg_match('/CloudFlare\-AlwaysOnline/', $useragent)) {
            return new CloudFlareAlwaysOnline($useragent, []);
        } elseif (preg_match('/Phantom\.js bot/', $useragent)) {
            return new PhantomJsBot($useragent, []);
        } elseif (preg_match('/Phantom/', $useragent)) {
            return new PhantomBrowser($useragent, []);
        } elseif (preg_match('/Shrook/', $useragent)) {
            return new Shrook($useragent, []);
        } elseif (preg_match('/netEstate NE Crawler/', $useragent)) {
            return new NetEstateCrawler($useragent, []);
        } elseif (preg_match('/garlikcrawler/i', $useragent)) {
            return new GarlikCrawler($useragent, []);
        } elseif (preg_match('/metageneratorcrawler/i', $useragent)) {
            return new MetaGeneratorCrawler($useragent, []);
        } elseif (preg_match('/ScreenerBot/', $useragent)) {
            return new ScreenerBot($useragent, []);
        } elseif (preg_match('/WebTarantula\.com Crawler/', $useragent)) {
            return new WebTarantula($useragent, []);
        } elseif (preg_match('/BacklinkCrawler/', $useragent)) {
            return new BacklinkCrawler($useragent, []);
        } elseif (preg_match('/LinksCrawler/', $useragent)) {
            return new LinksCrawler($useragent, []);
        } elseif (preg_match('/(ssearch\_bot|sSearch Crawler)/', $useragent)) {
            return new SsearchCrawler($useragent, []);
        } elseif (preg_match('/HRCrawler/', $useragent)) {
            return new HrCrawler($useragent, []);
        } elseif (preg_match('/ICC\-Crawler/', $useragent)) {
            return new IccCrawler($useragent, []);
        } elseif (preg_match('/Arachnida Web Crawler/', $useragent)) {
            return new ArachnidaWebCrawler($useragent, []);
        } elseif (preg_match('/Finderlein Research Crawler/', $useragent)) {
            return new FinderleinResearchCrawler($useragent, []);
        } elseif (preg_match('/TestCrawler/', $useragent)) {
            return new TestCrawler($useragent, []);
        } elseif (preg_match('/Scopia Crawler/', $useragent)) {
            return new ScopiaCrawler($useragent, []);
        } elseif (preg_match('/Crawler/', $useragent)) {
            return new Crawler($useragent, []);
        } elseif (preg_match('/MetaJobBot/', $useragent)) {
            return new MetaJobBot($useragent, []);
        } elseif (preg_match('/jig browser web/', $useragent)) {
            return new JigBrowserWeb($useragent, []);
        } elseif (preg_match('/T\-H\-U\-N\-D\-E\-R\-S\-T\-O\-N\-E/', $useragent)) {
            return new TexisWebscript($useragent, []);
        } elseif (preg_match('/focuseekbot/', $useragent)) {
            return new Focuseekbot($useragent, []);
        } elseif (preg_match('/vBSEO/', $useragent)) {
            return new VbulletinSeoBot($useragent, []);
        } elseif (preg_match('/kgbody/', $useragent)) {
            return new Kgbody($useragent, []);
        } elseif (preg_match('/JobdiggerSpider/', $useragent)) {
            return new JobdiggerSpider($useragent, []);
        } elseif (preg_match('/imrbot/', $useragent)) {
            return new MignifyBot($useragent, []);
        } elseif (preg_match('/kulturarw3/', $useragent)) {
            return new Kulturarw3($useragent, []);
        } elseif (preg_match('/LucidWorks/', $useragent)) {
            return new LucidworksBot($useragent, []);
        } elseif (preg_match('/MerchantCentricBot/', $useragent)) {
            return new MerchantCentricBot($useragent, []);
        } elseif (preg_match('/Nett\.io bot/', $useragent)) {
            return new NettioBot($useragent, []);
        } elseif (preg_match('/SemanticBot/', $useragent)) {
            return new SemanticBot($useragent, []);
        } elseif (preg_match('/tweetedtimes/i', $useragent)) {
            return new TweetedTimesBot($useragent, []);
        } elseif (preg_match('/vkShare/', $useragent)) {
            return new VkShare($useragent, []);
        } elseif (preg_match('/Yahoo Ad monitoring/', $useragent)) {
            return new YahooAdMonitoring($useragent, []);
        } elseif (preg_match('/YioopBot/', $useragent)) {
            return new YioopBot($useragent, []);
        } elseif (preg_match('/zitebot/', $useragent)) {
            return new Zitebot($useragent, []);
        } elseif (preg_match('/Espial/', $useragent)) {
            return new EspialTvBrowser($useragent, []);
        } elseif (preg_match('/SiteCon/', $useragent)) {
            return new SiteCon($useragent, []);
        } elseif (preg_match('/iBooks Author/', $useragent)) {
            return new IbooksAuthor($useragent, []);
        } elseif (preg_match('/iWeb/', $useragent)) {
            return new Iweb($useragent, []);
        } elseif (preg_match('/NewsFire/', $useragent)) {
            return new NewsFire($useragent, []);
        } elseif (preg_match('/RMSnapKit/', $useragent)) {
            return new RmSnapKit($useragent, []);
        } elseif (preg_match('/Sandvox/', $useragent)) {
            return new Sandvox($useragent, []);
        } elseif (preg_match('/TubeTV/', $useragent)) {
            return new TubeTv($useragent, []);
        } elseif (preg_match('/Elluminate Live/', $useragent)) {
            return new ElluminateLive($useragent, []);
        } elseif (preg_match('/Element Browser/', $useragent)) {
            return new ElementBrowser($useragent, []);
        } elseif (preg_match('/K\-Meleon/', $useragent)) {
            return new Kmeleon($useragent, []);
        } elseif (preg_match('/Esribot/', $useragent)) {
            return new Esribot($useragent, []);
        } elseif (preg_match('/QuickLook/', $useragent)) {
            return new QuickLook($useragent, []);
        } elseif (preg_match('/dillo/i', $useragent)) {
            return new Dillo($useragent, []);
        } elseif (preg_match('/Digg/', $useragent)) {
            return new DiggBot($useragent, []);
        } elseif (preg_match('/Zetakey/', $useragent)) {
            return new ZetakeyBrowser($useragent, []);
        } elseif (preg_match('/getprismatic\.com/', $useragent)) {
            return new PrismaticApp($useragent, []);
        } elseif (preg_match('/(FOMA|SH05C)/', $useragent)) {
            return new Sharp($useragent, []);
        } elseif (preg_match('/OpenWebKitSharp/', $useragent)) {
            return new OpenWebkitSharp($useragent, []);
        } elseif (preg_match('/AjaxSnapBot/', $useragent)) {
            return new AjaxSnapBot($useragent, []);
        } elseif (preg_match('/Owler/', $useragent)) {
            return new OwlerBot($useragent, []);
        } elseif (preg_match('/Yahoo Link Preview/', $useragent)) {
            return new YahooLinkPreview($useragent, []);
        } elseif (preg_match('/pub\-crawler/', $useragent)) {
            return new PubCrawler($useragent, []);
        } elseif (preg_match('/Kraken/', $useragent)) {
            return new Kraken($useragent, []);
        } elseif (preg_match('/Qwantify/', $useragent)) {
            return new Qwantify($useragent, []);
        } elseif (preg_match('/SetLinks bot/', $useragent)) {
            return new SetLinksCrawler($useragent, []);
        } elseif (preg_match('/MegaIndex\.ru/', $useragent)) {
            return new MegaIndexBot($useragent, []);
        } elseif (preg_match('/Cliqzbot/', $useragent)) {
            return new Cliqzbot($useragent, []);
        } elseif (preg_match('/DAWINCI ANTIPLAG SPIDER/', $useragent)) {
            return new DawinciAntiplagSpider($useragent, []);
        } elseif (preg_match('/AdvBot/', $useragent)) {
            return new AdvBot($useragent, []);
        } elseif (preg_match('/DuckDuckGo\-Favicons\-Bot/', $useragent)) {
            return new DuckDuckFaviconsBot($useragent, []);
        } elseif (preg_match('/ZyBorg/', $useragent)) {
            return new WiseNutSearchEngineCrawler($useragent, []);
        } elseif (preg_match('/HyperCrawl/', $useragent)) {
            return new HyperCrawl($useragent, []);
        } elseif (preg_match('/ARCHIVE\.ORG\.UA crawler/', $useragent)) {
            return new ArchiveOrgBot($useragent, []);
        } elseif (preg_match('/worldwebheritage/', $useragent)) {
            return new WorldwebheritageBot($useragent, []);
        } elseif (preg_match('/BegunAdvertising/', $useragent)) {
            return new BegunAdvertisingBot($useragent, []);
        } elseif (preg_match('/TrendWinHttp/', $useragent)) {
            return new TrendWinHttp($useragent, []);
        } elseif (preg_match('/(winhttp|winhttprequest)/i', $useragent)) {
            return new WinHttpRequest($useragent, []);
        } elseif (preg_match('/SkypeUriPreview/', $useragent)) {
            return new SkypeUriPreview($useragent, []);
        } elseif (preg_match('/ScoutJet/', $useragent)) {
            return new Scoutjet($useragent, []);
        } elseif (preg_match('/Lipperhey\-Kaus\-Australis/', $useragent)) {
            return new LipperheyKausAustralis($useragent, []);
        } elseif (preg_match('/Digincore bot/', $useragent)) {
            return new DigincoreBot($useragent, []);
        } elseif (preg_match('/Steeler/', $useragent)) {
            return new Steeler($useragent, []);
        } elseif (preg_match('/Orangebot/', $useragent)) {
            return new Orangebot($useragent, []);
        } elseif (preg_match('/Jasmine/', $useragent)) {
            return new Jasmine($useragent, []);
        } elseif (preg_match('/electricmonk/', $useragent)) {
            return new DueDilCrawler($useragent, []);
        } elseif (preg_match('/yoozBot/', $useragent)) {
            return new YoozBot($useragent, []);
        } elseif (preg_match('/online\-webceo\-bot/', $useragent)) {
            return new WebceoBot($useragent, []);
        } elseif (preg_match('/^Mozilla\/5\.0 \(.*\) Gecko\/.*\/\d+/', $useragent)
            && !preg_match('/Netscape/', $useragent)
        ) {
            return new Firefox($useragent, []);
        } elseif (preg_match('/^Mozilla\/5\.0 \(.*rv:\d+\.\d+.*\) Gecko\/.*\//', $useragent)
            && !preg_match('/Netscape/', $useragent)
        ) {
            return new Firefox($useragent, []);
        } elseif (preg_match('/Netscape/', $useragent)) {
            return new Netscape($useragent, []);
        } elseif (preg_match('/^Mozilla\/5\.0$/', $useragent)) {
            return new UnknownBrowser($useragent, []);
        } elseif (preg_match('/Virtuoso/', $useragent)) {
            return new Virtuoso($useragent, []);
        } elseif (preg_match('/^Mozilla\/(3|4)\.\d+/', $useragent, $matches)
            && !preg_match('/(msie|android)/i', $useragent, $matches)
        ) {
            return new Netscape($useragent, []);
        } elseif (preg_match('/^Dalvik\/\d/', $useragent)) {
            return new Dalvik($useragent, []);
        } elseif (preg_match('/niki\-bot/', $useragent)) {
            return new NikiBot($useragent, []);
        } elseif (preg_match('/ContextAd Bot/', $useragent)) {
            return new ContextadBot($useragent, []);
        } elseif (preg_match('/integrity/', $useragent)) {
            return new Integrity($useragent, []);
        } elseif (preg_match('/masscan/', $useragent)) {
            return new DownloadAccelerator($useragent, []);
        } elseif (preg_match('/ZmEu/', $useragent)) {
            return new ZmEu($useragent, []);
        } elseif (preg_match('/sogou web spider/i', $useragent)) {
            return new SogouWebSpider($useragent, []);
        } elseif (preg_match('/(OpenWave|UP\.Browser|UP\/)/', $useragent)) {
            return new Openwave($useragent, []);
        } elseif (preg_match('/(ObigoInternetBrowser|obigo\-browser|Obigo|Teleca)(\/|-)Q(\d+)/', $useragent)) {
            return new ObigoQ($useragent, []);
        } elseif (preg_match('/(Teleca|Obigo|MIC\/|AU\-MIC)/', $useragent)) {
            return new TelecaObigo($useragent, []);
        } elseif (preg_match('/DavClnt/', $useragent)) {
            return new MicrosoftWebDav($useragent, []);
        } elseif (preg_match('/XING\-contenttabreceiver/', $useragent)) {
            return new XingContenttabreceiver($useragent, []);
        } elseif (preg_match('/Slingstone/', $useragent)) {
            return new YahooSlingstone($useragent, []);
        } elseif (preg_match('/BOT for JCE/', $useragent)) {
            return new BotForJce($useragent, []);
        } elseif (preg_match('/Validator\.nu\/LV/', $useragent)) {
            return new W3cValidatorNuLv($useragent, []);
        } elseif (preg_match('/Curb/', $useragent)) {
            return new Curb($useragent, []);
        } elseif (preg_match('/link_thumbnailer/', $useragent)) {
            return new LinkThumbnailer($useragent, []);
        } elseif (preg_match('/Ruby/', $useragent)) {
            return new Ruby($useragent, []);
        } elseif (preg_match('/securepoint cf/', $useragent)) {
            return new SecurepointContentFilter($useragent, []);
        } elseif (preg_match('/sogou\-spider/i', $useragent)) {
            return new SogouSpider($useragent, []);
        } elseif (preg_match('/rankflex/i', $useragent)) {
            return new RankFlex($useragent, []);
        } elseif (preg_match('/domnutch/i', $useragent)) {
            return new Domnutch($useragent, []);
        } elseif (preg_match('/discovered/i', $useragent)) {
            return new DiscoverEd($useragent, []);
        } elseif (preg_match('/nutch/i', $useragent)) {
            return new Nutch($useragent, []);
        } elseif (preg_match('/boardreader favicon fetcher/i', $useragent)) {
            return new BoardReaderFaviconFetcher($useragent, []);
        } elseif (preg_match('/checksite verification agent/i', $useragent)) {
            return new CheckSiteVerificationAgent($useragent, []);
        } elseif (preg_match('/experibot/i', $useragent)) {
            return new Experibot($useragent, []);
        } elseif (preg_match('/feedblitz/i', $useragent)) {
            return new FeedBlitz($useragent, []);
        } elseif (preg_match('/rss2html/i', $useragent)) {
            return new Rss2Html($useragent, []);
        } elseif (preg_match('/feedlyapp/i', $useragent)) {
            return new FeedlyApp($useragent, []);
        } elseif (preg_match('/genderanalyzer/i', $useragent)) {
            return new Genderanalyzer($useragent, []);
        } elseif (preg_match('/gooblog/i', $useragent)) {
            return new GooBlog($useragent, []);
        } elseif (preg_match('/tumblr/i', $useragent)) {
            return new TumblrApp($useragent, []);
        } elseif (preg_match('/w3c\_i18n\-checker/i', $useragent)) {
            return new W3cI18nChecker($useragent, []);
        } elseif (preg_match('/w3c\_unicorn/i', $useragent)) {
            return new W3cUnicorn($useragent, []);
        } elseif (preg_match('/alltop/i', $useragent)) {
            return new AlltopApp($useragent, []);
        } elseif (preg_match('/internetseer/i', $useragent)) {
            return new InternetSeer($useragent, []);
        } elseif (preg_match('/ADmantX Platform Semantic Analyzer/', $useragent)) {
            return new AdmantxPlatformSemanticAnalyzer($useragent, []);
        } elseif (preg_match('/UniversalFeedParser/', $useragent)) {
            return new UniversalFeedParser($useragent, []);
        } elseif (preg_match('/(binlar|larbin)/i', $useragent)) {
            return new Larbin($useragent, []);
        } elseif (preg_match('/unityplayer/i', $useragent)) {
            return new UnityWebPlayer($useragent, []);
        } elseif (preg_match('/WeSEE\:Search/', $useragent)) {
            return new WeseeSearch($useragent, []);
        } elseif (preg_match('/WeSEE\:Ads/', $useragent)) {
            return new WeseeAds($useragent, []);
        } elseif (preg_match('/A6\-Indexer/', $useragent)) {
            return new A6Indexer($useragent, []);
        } elseif (preg_match('/NerdyBot/', $useragent)) {
            return new NerdyBot($useragent, []);
        } elseif (preg_match('/Peeplo Screenshot Bot/', $useragent)) {
            return new PeeploScreenshotBot($useragent, []);
        } elseif (preg_match('/CCBot/', $useragent)) {
            return new CcBot($useragent, []);
        } elseif (preg_match('/visionutils/', $useragent)) {
            return new VisionUtils($useragent, []);
        } elseif (preg_match('/Feedly/', $useragent)) {
            return new Feedly($useragent, []);
        } elseif (preg_match('/Photon/', $useragent)) {
            return new Photon($useragent, []);
        } elseif (preg_match('/WDG\_Validator/', $useragent)) {
            return new WdgHtmlValidator($useragent, []);
        } elseif (preg_match('/Aboundex/', $useragent)) {
            return new Aboundexbot($useragent, []);
        } elseif (preg_match('/YisouSpider/', $useragent)) {
            return new YisouSpider($useragent, []);
        } elseif (preg_match('/hivaBot/', $useragent)) {
            return new HivaBot($useragent, []);
        } elseif (preg_match('/Comodo Spider/', $useragent)) {
            return new ComodoSpider($useragent, []);
        } elseif (preg_match('/OpenWebSpider/i', $useragent)) {
            return new OpenWebSpider($useragent, []);
        } elseif (preg_match('/R6_CommentReader/i', $useragent)) {
            return new R6CommentReader($useragent, []);
        } elseif (preg_match('/R6_FeedFetcher/i', $useragent)) {
            return new R6Feedfetcher($useragent, []);
        } elseif (preg_match('/(psbot\-image|psbot\-page)/i', $useragent)) {
            return new Picsearchbot($useragent, []);
        } elseif (preg_match('/Bloglovin/', $useragent)) {
            return new BloglovinBot($useragent, []);
        } elseif (preg_match('/viralvideochart/i', $useragent)) {
            return new ViralvideochartBot($useragent, []);
        } elseif (preg_match('/MetaHeadersBot/', $useragent)) {
            return new MetaHeadersBot($useragent, []);
        } elseif (preg_match('/Zend\_Http\_Client/', $useragent)) {
            return new ZendHttpClient($useragent, []);
        } elseif (preg_match('/wget/i', $useragent)) {
            return new Wget($useragent, []);
        } elseif (preg_match('/Scrapy/', $useragent)) {
            return new ScrapyBot($useragent, []);
        } elseif (preg_match('/Moozilla/', $useragent)) {
            return new Moozilla($useragent, []);
        } elseif (preg_match('/AntBot/', $useragent)) {
            return new AntBot($useragent, []);
        } elseif (preg_match('/Browsershots/', $useragent)) {
            return new Browsershots($useragent, []);
        } elseif (preg_match('/revolt/', $useragent)) {
            return new BotRevolt($useragent, []);
        } elseif (preg_match('/pdrlabs/i', $useragent)) {
            return new PdrlabsBot($useragent, []);
        } elseif (preg_match('/elinks/i', $useragent)) {
            return new Elinks($useragent, []);
        } elseif (preg_match('/Links/', $useragent)) {
            return new Links($useragent, []);
        } elseif (preg_match('/Airmail/', $useragent)) {
            return new Airmail($useragent, []);
        } elseif (preg_match('/SonyEricsson/', $useragent)) {
            return new SonyEricsson($useragent, []);
        } elseif (preg_match('/WEB\.DE MailCheck/', $useragent)) {
            return new WebdeMailCheck($useragent, []);
        } elseif (preg_match('/Screaming Frog SEO Spider/', $useragent)) {
            return new ScreamingFrogSeoSpider($useragent, []);
        } elseif (preg_match('/AndroidDownloadManager/', $useragent)) {
            return new AndroidDownloadManager($useragent, []);
        } elseif (preg_match('/Go ([\d\.]+) package http/', $useragent)) {
            return new GoHttpClient($useragent, []);
        } elseif (preg_match('/Go-http-client/', $useragent)) {
            return new GoHttpClient($useragent, []);
        } elseif (preg_match('/Proxy Gear Pro/', $useragent)) {
            return new ProxyGearPro($useragent, []);
        } elseif (preg_match('/WAP Browser\/MAUI/', $useragent)) {
            return new MauiWapBrowser($useragent, []);
        } elseif (preg_match('/Tiny Tiny RSS/', $useragent)) {
            return new TinyTinyRss($useragent, []);
        } elseif (preg_match('/Readability/', $useragent)) {
            return new Readability($useragent, []);
        } elseif (preg_match('/NSPlayer/', $useragent)) {
            return new WindowsMediaPlayer($useragent, []);
        } elseif (preg_match('/Pingdom/', $useragent)) {
            return new Pingdom($useragent, []);
        } elseif (preg_match('/crazywebcrawler/i', $useragent)) {
            return new Crazywebcrawler($useragent, []);
        } elseif (preg_match('/GG PeekBot/', $useragent)) {
            return new GgPeekBot($useragent, []);
        } elseif (preg_match('/iTunes/', $useragent)) {
            return new Itunes($useragent, []);
        } elseif (preg_match('/LibreOffice/', $useragent)) {
            return new LibreOffice($useragent, []);
        } elseif (preg_match('/OpenOffice/', $useragent)) {
            return new OpenOffice($useragent, []);
        } elseif (preg_match('/ThumbnailAgent/', $useragent)) {
            return new ThumbnailAgent($useragent, []);
        } elseif (preg_match('/LinkStats Bot/', $useragent)) {
            return new LinkStatsBot($useragent, []);
        } elseif (preg_match('/eZ Publish Link Validator/', $useragent)) {
            return new EzPublishLinkValidator($useragent, []);
        } elseif (preg_match('/ThumbSniper/', $useragent)) {
            return new ThumbSniper($useragent, []);
        } elseif (preg_match('/stq\_bot/', $useragent)) {
            return new SearchteqBot($useragent, []);
        } elseif (preg_match('/SNK Screenshot Bot/', $useragent)) {
            return new SnkScreenshotBot($useragent, []);
        } elseif (preg_match('/SynHttpClient/', $useragent)) {
            return new SynHttpClient($useragent, []);
        } elseif (preg_match('/HTTPClient/', $useragent)) {
            return new HttpClient($useragent, []);
        } elseif (preg_match('/T\-Online Browser/', $useragent)) {
            return new TonlineBrowser($useragent, []);
        } elseif (preg_match('/ImplisenseBot/', $useragent)) {
            return new ImplisenseBot($useragent, []);
        } elseif (preg_match('/BuiBui\-Bot/', $useragent)) {
            return new BuiBuiBot($useragent, []);
        } elseif (preg_match('/thumbshots\-de\-bot/', $useragent)) {
            return new ThumbShotsDeBot($useragent, []);
        } elseif (preg_match('/python\-requests/', $useragent)) {
            return new PythonRequests($useragent, []);
        } elseif (preg_match('/Python\-urllib/', $useragent)) {
            return new PythonUrlLib($useragent, []);
        } elseif (preg_match('/Bot\.AraTurka\.com/', $useragent)) {
            return new BotAraTurka($useragent, []);
        } elseif (preg_match('/http\_requester/', $useragent)) {
            return new HttpRequester($useragent, []);
        } elseif (preg_match('/WhatWeb/', $useragent)) {
            return new WhatWebWebScanner($useragent, []);
        } elseif (preg_match('/isc header collector handlers/', $useragent)) {
            return new IscHeaderCollectorHandlers($useragent, []);
        } elseif (preg_match('/Thumbor/', $useragent)) {
            return new Thumbor($useragent, []);
        } elseif (preg_match('/Forum Poster/', $useragent)) {
            return new ForumPoster($useragent, []);
        } elseif (preg_match('/crawler4j/', $useragent)) {
            return new Crawler4j($useragent, []);
        } elseif (preg_match('/Facebot/', $useragent)) {
            return new FaceBot($useragent, []);
        } elseif (preg_match('/NetzCheckBot/', $useragent)) {
            return new NetzCheckBot($useragent, []);
        } elseif (preg_match('/MIB/', $useragent)) {
            return new MotorolaInternetBrowser($useragent, []);
        } elseif (preg_match('/facebookscraper/', $useragent)) {
            return new Facebookscraper($useragent, []);
        } elseif (preg_match('/Zookabot/', $useragent)) {
            return new Zookabot($useragent, []);
        } elseif (preg_match('/MetaURI/', $useragent)) {
            return new MetaUri($useragent, []);
        } elseif (preg_match('/FreeWebMonitoring SiteChecker/', $useragent)) {
            return new FreeWebMonitoringSiteChecker($useragent, []);
        } elseif (preg_match('/IPv4Scan/', $useragent)) {
            return new Ipv4Scan($useragent, []);
        } elseif (preg_match('/RED/', $useragent)) {
            return new Redbot($useragent, []);
        } elseif (preg_match('/domainsbot/', $useragent)) {
            return new DomainsBot($useragent, []);
        } elseif (preg_match('/BUbiNG/', $useragent)) {
            return new Bubing($useragent, []);
        } elseif (preg_match('/RamblerMail/', $useragent)) {
            return new RamblerMail($useragent, []);
        } elseif (preg_match('/ichiro\/mobile/', $useragent)) {
            return new IchiroMobileBot($useragent, []);
        } elseif (preg_match('/ichiro/', $useragent)) {
            return new IchiroBot($useragent, []);
        } elseif (preg_match('/iisbot/', $useragent)) {
            return new IisBot($useragent, []);
        } elseif (preg_match('/JoobleBot/', $useragent)) {
            return new JoobleBot($useragent, []);
        } elseif (preg_match('/Superfeedr bot/', $useragent)) {
            return new SuperfeedrBot($useragent, []);
        } elseif (preg_match('/FeedBurner/', $useragent)) {
            return new FeedBurner($useragent, []);
        } elseif (preg_match('/Fastladder/', $useragent)) {
            return new FastladderFeedFetcher($useragent, []);
        } elseif (preg_match('/livedoor/', $useragent)) {
            return new LivedoorFeedFetcher($useragent, []);
        } elseif (preg_match('/Icarus6j/', $useragent)) {
            return new Icarus6j($useragent, []);
        } elseif (preg_match('/wsr\-agent/', $useragent)) {
            return new WsrAgent($useragent, []);
        } elseif (preg_match('/Blogshares Spiders/', $useragent)) {
            return new BlogsharesSpiders($useragent, []);
        } elseif (preg_match('/TinEye\-bot/', $useragent)) {
            return new TinEyeBot($useragent, []);
        } elseif (preg_match('/QuickiWiki/', $useragent)) {
            return new QuickiWikiBot($useragent, []);
        } elseif (preg_match('/PycURL/', $useragent)) {
            return new PyCurl($useragent, []);
        } elseif (preg_match('/libcurl\-agent/', $useragent)) {
            return new Libcurl($useragent, []);
        } elseif (preg_match('/Taproot/', $useragent)) {
            return new TaprootBot($useragent, []);
        } elseif (preg_match('/GuzzleHttp/', $useragent)) {
            return new GuzzleHttpClient($useragent, []);
        } elseif (preg_match('/curl/i', $useragent)) {
            return new Curl($useragent, []);
        } elseif (preg_match('/^PHP/', $useragent)) {
            return new Php($useragent, []);
        } elseif (preg_match('/Apple\-PubSub/', $useragent)) {
            return new ApplePubSub($useragent, []);
        } elseif (preg_match('/SimplePie/', $useragent)) {
            return new SimplePie($useragent, []);
        } elseif (preg_match('/BigBozz/', $useragent)) {
            return new BigBozz($useragent, []);
        } elseif (preg_match('/ECCP/', $useragent)) {
            return new Eccp($useragent, []);
        } elseif (preg_match('/facebookexternalhit/', $useragent)) {
            return new FacebookExternalHit($useragent, []);
        } elseif (preg_match('/GigablastOpenSource/', $useragent)) {
            return new GigablastOpenSource($useragent, []);
        } elseif (preg_match('/WebIndex/', $useragent)) {
            return new WebIndex($useragent, []);
        } elseif (preg_match('/Prince/', $useragent)) {
            return new Prince($useragent, []);
        } elseif (preg_match('/adsense\-snapshot\-google/i', $useragent)) {
            return new GoogleAdsenseSnapshot($useragent, []);
        } elseif (preg_match('/Amazon CloudFront/', $useragent)) {
            return new AmazonCloudFront($useragent, []);
        } elseif (preg_match('/bandscraper/', $useragent)) {
            return new Bandscraper($useragent, []);
        } elseif (preg_match('/bitlybot/', $useragent)) {
            return new BitlyBot($useragent, []);
        } elseif (preg_match('/^bot$/', $useragent)) {
            return new BotBot($useragent, []);
        } elseif (preg_match('/cars\-app\-browser/', $useragent)) {
            return new CarsAppBrowser($useragent, []);
        } elseif (preg_match('/Coursera\-Mobile/', $useragent)) {
            return new CourseraMobileApp($useragent, []);
        } elseif (preg_match('/Crowsnest/', $useragent)) {
            return new CrowsnestMobileApp($useragent, []);
        } elseif (preg_match('/Dorado WAP\-Browser/', $useragent)) {
            return new DoradoWapBrowser($useragent, []);
        } elseif (preg_match('/Goldfire Server/', $useragent)) {
            return new GoldfireServer($useragent, []);
        } elseif (preg_match('/EventMachine HttpClient/', $useragent)) {
            return new EventMachineHttpClient($useragent, []);
        } elseif (preg_match('/iBall/', $useragent)) {
            return new Iball($useragent, []);
        } elseif (preg_match('/InAGist URL Resolver/', $useragent)) {
            return new InagistUrlResolver($useragent, []);
        } elseif (preg_match('/Jeode/', $useragent)) {
            return new Jeode($useragent, []);
        } elseif (preg_match('/kraken/', $useragent)) {
            return new Krakenjs($useragent, []);
        } elseif (preg_match('/com\.linkedin/', $useragent)) {
            return new LinkedInBot($useragent, []);
        } elseif (preg_match('/LivelapBot/', $useragent)) {
            return new LivelapBot($useragent, []);
        } elseif (preg_match('/MixBot/', $useragent)) {
            return new MixBot($useragent, []);
        } elseif (preg_match('/BuSecurityProject/', $useragent)) {
            return new BuSecurityProject($useragent, []);
        } elseif (preg_match('/PageFreezer/', $useragent)) {
            return new PageFreezer($useragent, []);
        } elseif (preg_match('/restify/', $useragent)) {
            return new Restify($useragent, []);
        } elseif (preg_match('/ShowyouBot/', $useragent)) {
            return new ShowyouBot($useragent, []);
        } elseif (preg_match('/vlc/i', $useragent)) {
            return new VlcMediaPlayer($useragent, []);
        } elseif (preg_match('/WebRingChecker/', $useragent)) {
            return new WebRingChecker($useragent, []);
        } elseif (preg_match('/bot\-pge\.chlooe\.com/', $useragent)) {
            return new ChlooeBot($useragent, []);
        } elseif (preg_match('/seebot/', $useragent)) {
            return new SeeBot($useragent, []);
        } elseif (preg_match('/ltx71/', $useragent)) {
            return new Ltx71($useragent, []);
        } elseif (preg_match('/CookieReports/', $useragent)) {
            return new CookieReportsBot($useragent, []);
        } elseif (preg_match('/Elmer/', $useragent)) {
            return new Elmer($useragent, []);
        } elseif (preg_match('/Iframely/', $useragent)) {
            return new IframelyBot($useragent, []);
        } elseif (preg_match('/MetaInspector/', $useragent)) {
            return new MetaInspector($useragent, []);
        } elseif (preg_match('/Microsoft\-CryptoAPI/', $useragent)) {
            return new MicrosoftCryptoApi($useragent, []);
        } elseif (preg_match('/OWASP\_SECRET\_BROWSER/', $useragent)) {
            return new OwaspSecretBrowser($useragent, []);
        } elseif (preg_match('/SMRF URL Expander/', $useragent)) {
            return new SmrfUrlExpander($useragent, []);
        } elseif (preg_match('/Speedy Spider/', $useragent)) {
            return new Entireweb($useragent, []);
        } elseif (preg_match('/kizasi\-spider/', $useragent)) {
            return new Kizasispider($useragent, []);
        } elseif (preg_match('/Superarama\.com \- BOT/', $useragent)) {
            return new SuperaramaComBot($useragent, []);
        } elseif (preg_match('/WNMbot/', $useragent)) {
            return new Wnmbot($useragent, []);
        } elseif (preg_match('/Website Explorer/', $useragent)) {
            return new WebsiteExplorer($useragent, []);
        } elseif (preg_match('/city\-map screenshot service/', $useragent)) {
            return new CitymapScreenshotService($useragent, []);
        } elseif (preg_match('/gosquared\-thumbnailer/', $useragent)) {
            return new GosquaredThumbnailer($useragent, []);
        } elseif (preg_match('/optivo\(R\) NetHelper/', $useragent)) {
            return new OptivoNetHelper($useragent, []);
        } elseif (preg_match('/pr\-cy\.ru Screenshot Bot/', $useragent)) {
            return new ScreenshotBot($useragent, []);
        } elseif (preg_match('/Cyberduck/', $useragent)) {
            return new Cyberduck($useragent, []);
        } elseif (preg_match('/Lynx/', $useragent)) {
            return new Lynx($useragent, []);
        } elseif (preg_match('/AccServer/', $useragent)) {
            return new AccServer($useragent, []);
        } elseif (preg_match('/SafeSearch microdata crawler/', $useragent)) {
            return new SafeSearchMicrodataCrawler($useragent, []);
        } elseif (preg_match('/iZSearch/', $useragent)) {
            return new IzSearchBot($useragent, []);
        } elseif (preg_match('/NetLyzer FastProbe/', $useragent)) {
            return new NetLyzerFastProbe($useragent, []);
        } elseif (preg_match('/MnoGoSearch/', $useragent)) {
            return new MnogoSearch($useragent, []);
        } elseif (preg_match('/uipbot/', $useragent)) {
            return new Uipbot($useragent, []);
        } elseif (preg_match('/mbot/', $useragent)) {
            return new Mbot($useragent, []);
        } elseif (preg_match('/MS Web Services Client Protocol/', $useragent)) {
            return new MicrosoftDotNetFrameworkClr($useragent, []);
        } elseif (preg_match('/(AtomicBrowser|AtomicLite)/', $useragent)) {
            return new AtomicBrowser($useragent, []);
        } elseif (preg_match('/AppEngine\-Google/', $useragent)) {
            return new GoogleAppEngine($useragent, []);
        } elseif (preg_match('/Feedfetcher\-Google/', $useragent)) {
            return new GoogleFeedfetcher($useragent, []);
        } elseif (preg_match('/Google/', $useragent)) {
            return new GoogleApp($useragent, []);
        } elseif (preg_match('/UnwindFetchor/', $useragent)) {
            return new UnwindFetchor($useragent, []);
        } elseif (preg_match('/Perfect%20Browser/', $useragent)) {
            return new PerfectBrowser($useragent, []);
        } elseif (preg_match('/Reeder/', $useragent)) {
            return new Reeder($useragent, []);
        } elseif (preg_match('/FastBrowser/', $useragent)) {
            return new FastBrowser($useragent, []);
        } elseif (preg_match('/CFNetwork/', $useragent)) {
            return new CfNetwork($useragent, []);
        } elseif (preg_match('/Y\!J\-(ASR|BSC)/', $useragent)) {
            return new YahooJapan($useragent, []);
        } elseif (preg_match('/test certificate info/', $useragent)) {
            return new TestCertificateInfo($useragent, []);
        } elseif (preg_match('/fastbot crawler/', $useragent)) {
            return new FastbotCrawler($useragent, []);
        } elseif (preg_match('/Riddler/', $useragent)) {
            return new Riddler($useragent, []);
        } elseif (preg_match('/SophosUpdateManager/', $useragent)) {
            return new SophosUpdateManager($useragent, []);
        } elseif (preg_match('/(Debian|Ubuntu) APT\-HTTP/', $useragent)) {
            return new AptHttpTransport($useragent, []);
        } elseif (preg_match('/urlgrabber/', $useragent)) {
            return new UrlGrabber($useragent, []);
        } elseif (preg_match('/UCS \(ESX\)/', $useragent)) {
            return new UniventionCorporateServer($useragent, []);
        } elseif (preg_match('/libwww\-perl/', $useragent)) {
            return new Libwww($useragent, []);
        } elseif (preg_match('/OpenBSD ftp/', $useragent)) {
            return new OpenBsdFtp($useragent, []);
        } elseif (preg_match('/SophosAgent/', $useragent)) {
            return new SophosAgent($useragent, []);
        } elseif (preg_match('/jupdate/', $useragent)) {
            return new Jupdate($useragent, []);
        } elseif (preg_match('/Roku\/DVP/', $useragent)) {
            return new RokuDvp($useragent, []);
        } elseif (preg_match('/VocusBot/', $useragent)) {
            return new VocusBot($useragent, []);
        } elseif (preg_match('/PostRank/', $useragent)) {
            return new PostRank($useragent, []);
        } elseif (preg_match('/rogerbot/i', $useragent)) {
            return new Rogerbot($useragent, []);
        } elseif (preg_match('/Safeassign/', $useragent)) {
            return new Safeassign($useragent, []);
        } elseif (preg_match('/ExaleadCloudView/', $useragent)) {
            return new ExaleadCloudView($useragent, []);
        } elseif (preg_match('/Typhoeus/', $useragent)) {
            return new Typhoeus($useragent, []);
        } elseif (preg_match('/Camo Asset Proxy/', $useragent)) {
            return new CamoAssetProxy($useragent, []);
        } elseif (preg_match('/YahooCacheSystem/', $useragent)) {
            return new YahooCacheSystem($useragent, []);
        } elseif (preg_match('/wmtips\.com/', $useragent)) {
            return new WebmasterTipsBot($useragent, []);
        } elseif (preg_match('/linkCheck/', $useragent)) {
            return new LinkCheck($useragent, []);
        } elseif (preg_match('/ABrowse/', $useragent)) {
            return new Abrowse($useragent, []);
        } elseif (preg_match('/GWPImages/', $useragent)) {
            return new GwpImages($useragent, []);
        } elseif (preg_match('/NoteTextView/', $useragent)) {
            return new NoteTextView($useragent, []);
        } elseif (preg_match('/NING/', $useragent)) {
            return new Ning($useragent, []);
        } elseif (preg_match('/Sprinklr/', $useragent)) {
            return new SprinklrBot($useragent, []);
        } elseif (preg_match('/URLChecker/', $useragent)) {
            return new UrlChecker($useragent, []);
        } elseif (preg_match('/newsme/', $useragent)) {
            return new NewsMe($useragent, []);
        } elseif (preg_match('/Traackr/', $useragent)) {
            return new Traackr($useragent, []);
        } elseif (preg_match('/nineconnections/', $useragent)) {
            return new NineConnections($useragent, []);
        } elseif (preg_match('/Xenu Link Sleuth/', $useragent)) {
            return new XenusLinkSleuth($useragent, []);
        } elseif (preg_match('/superagent/', $useragent)) {
            return new Superagent($useragent, []);
        } elseif (preg_match('/Goose/', $useragent)) {
            return new GooseExtractor($useragent, []);
        } elseif (preg_match('/AHC/', $useragent)) {
            return new AsynchronousHttpClient($useragent, []);
        } elseif (preg_match('/newspaper/', $useragent)) {
            return new Newspaper($useragent, []);
        } elseif (preg_match('/Hatena::Bookmark/', $useragent)) {
            return new HatenaBookmark($useragent, []);
        } elseif (preg_match('/EasyBib AutoCite/', $useragent)) {
            return new EasyBibAutoCite($useragent, []);
        } elseif (preg_match('/ShortLinkTranslate/', $useragent)) {
            return new ShortLinkTranslate($useragent, []);
        } elseif (preg_match('/Marketing Grader/', $useragent)) {
            return new MarketingGrader($useragent, []);
        } elseif (preg_match('/Grammarly/', $useragent)) {
            return new Grammarly($useragent, []);
        } elseif (preg_match('/Dispatch/', $useragent)) {
            return new Dispatch($useragent, []);
        } elseif (preg_match('/Raven Link Checker/', $useragent)) {
            return new RavenLinkChecker($useragent, []);
        } elseif (preg_match('/http\-kit/', $useragent)) {
            return new HttpKit($useragent, []);
        } elseif (preg_match('/sfFeedReader/', $useragent)) {
            return new SymfonyRssReader($useragent, []);
        } elseif (preg_match('/Twikle/', $useragent)) {
            return new TwikleBot($useragent, []);
        } elseif (preg_match('/node\-fetch/', $useragent)) {
            return new NodeFetch($useragent, []);
        } elseif (preg_match('/BrokenLinkCheck\.com/', $useragent)) {
            return new BrokenLinkCheck($useragent, []);
        } elseif (preg_match('/BCKLINKS/', $useragent)) {
            return new BckLinks($useragent, []);
        } elseif (preg_match('/Faraday/', $useragent)) {
            return new Faraday($useragent, []);
        } elseif (preg_match('/gettor/', $useragent)) {
            return new Gettor($useragent, []);
        } elseif (preg_match('/SEOstats/', $useragent)) {
            return new SeoStats($useragent, []);
        } elseif (preg_match('/ZnajdzFoto\/Image/', $useragent)) {
            return new ZnajdzFotoImageBot($useragent, []);
        } elseif (preg_match('/infoX\-WISG/', $useragent)) {
            return new InfoxWisg($useragent, []);
        } elseif (preg_match('/wscheck\.com/', $useragent)) {
            return new WscheckBot($useragent, []);
        } elseif (preg_match('/Tweetminster/', $useragent)) {
            return new TweetminsterBot($useragent, []);
        } elseif (preg_match('/Astute SRM/', $useragent)) {
            return new AstuteSocial($useragent, []);
        } elseif (preg_match('/LongURL API/', $useragent)) {
            return new LongUrlBot($useragent, []);
        } elseif (preg_match('/Trove/', $useragent)) {
            return new TroveBot($useragent, []);
        } elseif (preg_match('/Melvil Favicon/', $useragent)) {
            return new MelvilFaviconBot($useragent, []);
        } elseif (preg_match('/Melvil/', $useragent)) {
            return new MelvilBot($useragent, []);
        } elseif (preg_match('/Pearltrees/', $useragent)) {
            return new PearltreesBot($useragent, []);
        } elseif (preg_match('/Svven\-Summarizer/', $useragent)) {
            return new SvvenSummarizerBot($useragent, []);
        } elseif (preg_match('/Athena Site Analyzer/', $useragent)) {
            return new AthenaSiteAnalyzer($useragent, []);
        } elseif (preg_match('/Exploratodo/', $useragent)) {
            return new ExploratodoBot($useragent, []);
        } elseif (preg_match('/WhatsApp/', $useragent)) {
            return new WhatsApp($useragent, []);
        } elseif (preg_match('/DDG\-Android\-/', $useragent)) {
            return new DuckDuckApp($useragent, []);
        } elseif (preg_match('/WebCorp/', $useragent)) {
            return new WebCorp($useragent, []);
        } elseif (preg_match('/ROR Sitemap Generator/', $useragent)) {
            return new RorSitemapGenerator($useragent, []);
        } elseif (preg_match('/AuditMyPC Webmaster Tool/', $useragent)) {
            return new AuditmypcWebmasterTool($useragent, []);
        } elseif (preg_match('/XmlSitemapGenerator/', $useragent)) {
            return new XmlSitemapGenerator($useragent, []);
        } elseif (preg_match('/Stratagems Kumo/', $useragent)) {
            return new StratagemsKumo($useragent, []);
        } elseif (preg_match('/YOURLS/', $useragent)) {
            return new Yourls($useragent, []);
        } elseif (preg_match('/Embed PHP Library/', $useragent)) {
            return new EmbedPhpLibrary($useragent, []);
        } elseif (preg_match('/SPIP/', $useragent)) {
            return new Spip($useragent, []);
        } elseif (preg_match('/Friendica/', $useragent)) {
            return new Friendica($useragent, []);
        } elseif (preg_match('/MagpieRSS/', $useragent)) {
            return new MagpieRss($useragent, []);
        } elseif (preg_match('/Short URL Checker/', $useragent)) {
            return new ShortUrlChecker($useragent, []);
        } elseif (preg_match('/webnumbrFetcher/', $useragent)) {
            return new WebnumbrFetcher($useragent, []);
        } elseif (preg_match('/(WAP Browser|Spice QT\-75|KKT20\/MIDP)/', $useragent)) {
            return new WapBrowser($useragent, []);
        } elseif (preg_match('/java/i', $useragent)) {
            return new JavaStandardLibrary($useragent, []);
        } elseif (preg_match('/(unister\-test|unistertesting|unister\-https\-test)/i', $useragent)) {
            return new UnisterTesting($useragent, []);
        }

        return new UnknownBrowser($useragent, []);
    }
}
