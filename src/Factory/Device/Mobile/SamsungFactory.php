<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2017, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Factory\Device\Mobile;

use BrowserDetector\Factory;
use BrowserDetector\Loader\LoaderInterface;
use Stringy\Stringy;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class SamsungFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'sm-t532'   => 'samsung sm-t532',
        'sm-a9000'  => 'sm-a9000',
        'sm-a810yz' => 'samsung sm-a810yz',
        'sm-a810f'  => 'samsung sm-a810f',
        'sm-a800f'  => 'sm-a800f',
        'sm-a800y'  => 'sm-a800y',
        'sm-a800i'  => 'sm-a800i',
        'sm-a8000'  => 'sm-a8000',
        'sm-s820l'  => 'sm-s820l',
        'sm-a720f'  => 'samsung sm-a720f',
        'sm-a710m'  => 'sm-a710m',
        'sm-a710fd' => 'sm-a710fd',
        'sm-a710f'  => 'sm-a710f',
        'sm-a7100'  => 'sm-a7100',
        'sm-a710y'  => 'sm-a710y',
        'sm-a700fd' => 'sm-a700fd',
        'sm-a700f'  => 'sm-a700f',
        'sm-a700s'  => 'sm-a700s',
        'sm-a700k'  => 'sm-a700k',
        'sm-a700l'  => 'sm-a700l',
        'sm-a700h'  => 'sm-a700h',
        'sm-a700yd' => 'sm-a700yd',
        'sm-a7000'  => 'sm-a7000',
        'sm-a7009'  => 'sm-a7009',
        'sm-a520s'  => 'samsung sm-a520s',
        'sm-a510fd' => 'sm-a510fd',
        'sm-a510f'  => 'sm-a510f',
        'sm-a510m'  => 'sm-a510m',
        'sm-a510y'  => 'sm-a510y',
        'sm-a5100'  => 'sm-a5100',
        'sm-a510s'  => 'sm-a510s',
        'sm-a500fu' => 'sm-a500fu',
        'sm-a500f'  => 'sm-a500f',
        'sm-a500h'  => 'sm-a500h',
        'sm-a500y'  => 'sm-a500y',
        'sm-a500l'  => 'sm-a500l',
        'sm-a5000'  => 'sm-a5000',
        'sm-a320f'  => 'samsung sm-a320f',
        'sm-a310f'  => 'sm-a310f',
        'sm-a300fu' => 'sm-a300fu',
        'sm-a300f'  => 'sm-a300f',
        'sm-a300h'  => 'sm-a300h',
        'sm-j710fn' => 'sm-j710fn',
        'sm-j710f'  => 'sm-j710f',
        'sm-j710m'  => 'sm-j710m',
        'sm-j710h'  => 'sm-j710h',
        'sm-j700f'  => 'sm-j700f',
        'sm-j700m'  => 'sm-j700m',
        'sm-j700h'  => 'sm-j700h',
        'sm-j510fn' => 'sm-j510fn',
        'sm-j510f'  => 'sm-j510f',
        'sm-j500fn' => 'sm-j500fn',
        'sm-j500f'  => 'sm-j500f',
        'sm-j500g'  => 'sm-j500g',
        'sm-j500m'  => 'sm-j500m',
        'sm-j500y'  => 'sm-j500y',
        'sm-j500h'  => 'sm-j500h',
        'sm-j5007'  => 'sm-j5007',
        'sm-j500'   => 'sm-j500',
        'galaxy j5' => 'sm-j500',
        'sm-j320p'  => 'samsung sm-j320p',
        'sm-j320g'  => 'sm-j320g',
        'sm-j320fn' => 'sm-j320fn',
        'sm-j320f'  => 'sm-j320f',
        'sm-j3109'  => 'sm-j3109',
        'sm-j120a'  => 'samsung sm-j120a',
        'sm-j120fn' => 'sm-j120fn',
        'sm-j120f'  => 'sm-j120f',
        'sm-j120g'  => 'sm-j120g',
        'sm-j120h'  => 'sm-j120h',
        'sm-j120m'  => 'sm-j120m',
        'sm-j110f'  => 'sm-j110f',
        'sm-j110g'  => 'sm-j110g',
        'sm-j110h'  => 'sm-j110h',
        'sm-j110l'  => 'sm-j110l',
        'sm-j110m'  => 'sm-j110m',
        'sm-j111f'  => 'sm-j111f',
        'sm-j105f'  => 'samsung sm-j105f',
        'sm-j105h'  => 'sm-j105h',
        'sm-j100h'  => 'sm-j100h',
        'sm-j100y'  => 'sm-j100y',
        'sm-j100f'  => 'sm-j100f',
        'sm-j100ml' => 'sm-j100ml',
        'sm-j200gu' => 'sm-j200gu',
        'sm-j200g'  => 'sm-j200g',
        'sm-j200f'  => 'sm-j200f',
        'sm-j200h'  => 'sm-j200h',
        'sm-j200bt' => 'sm-j200bt',
        'sm-j200y'  => 'sm-j200y',
        'sm-t280'   => 'sm-t280',
        'sm-t2105'  => 'sm-t2105',
        'sm-t210r'  => 'sm-t210r',
        'sm-t210l'  => 'sm-t210l',
        'sm-t210'   => 'sm-t210',
        'sm-t900'   => 'sm-t900',
        'sm-t819'   => 'sm-t819',
        'sm-t815y'  => 'sm-t815y',
        'sm-t815'   => 'sm-t815',
        'sm-t813'   => 'sm-t813',
        'sm-t810x'  => 'sm-t810x',
        'sm-t810'   => 'sm-t810',
        'sm-t805'   => 'sm-t805',
        'sm-t800'   => 'sm-t800',
        'sm-t719'   => 'sm-t719',
        'sm-t715'   => 'sm-t715',
        'sm-t713'   => 'sm-t713',
        'sm-t710'   => 'sm-t710',
        'sm-t705m'  => 'sm-t705m',
        'sm-t705'   => 'sm-t705',
        'sm-t700'   => 'sm-t700',
        'sm-t670'   => 'sm-t670',
        'sm-t585'   => 'sm-t585',
        'sm-t580'   => 'sm-t580',
        'sm-t550x'  => 'sm-t550x',
        'sm-t550'   => 'sm-t550',
        'sm-t555'   => 'sm-t555',
        'sm-t561'   => 'sm-t561',
        'sm-t560'   => 'sm-t560',
        'sm-t535'   => 'sm-t535',
        'sm-t533'   => 'sm-t533',
        'sm-t531'   => 'sm-t531',
        'sm - t531' => 'sm-t531',
        'sm-t530nu' => 'sm-t530nu',
        'sm-t530'   => 'sm-t530',
        'sm-t525'   => 'sm-t525',
        'sm-t520'   => 'sm-t520',
        'sm-t365'   => 'sm-t365',
        'sm-t355y'  => 'sm-t355y',
        'sm-t350'   => 'sm-t350',
        'sm-t335'   => 'sm-t335',
        'sm-t331'   => 'sm-t331',
        'sm-t330'   => 'sm-t330',
        'sm-t325'   => 'sm-t325',
        'sm-t320'   => 'sm-t320',
        'sm-t315'   => 'sm-t315',
        'sm-t311'   => 'sm-t311',
        'sm-t310'   => 'sm-t310',
        'sm-t235'   => 'sm-t235',
        'sm-t231'   => 'sm-t231',
        'sm-t230nu' => 'sm-t230nu',
        'sm-t230'   => 'sm-t230',
        'sm-t211'   => 'sm-t211',
        'sm-t116nu'   => 'samsung sm-t116nu',
        'sm-t116'   => 'sm-t116',
        'sm-t113'   => 'sm-t113',
        'sm-t111'   => 'sm-t111',
        'sm-t110'   => 'sm-t110',
        'sm-p907a'  => 'sm-p907a',
        'sm-p905m'  => 'sm-p905m',
        'sm-p905v'  => 'sm-p905v',
        'sm-p905'   => 'sm-p905',
        'sm-p901'   => 'sm-p901',
        'sm-p900'   => 'sm-p900',
        'sm-c900f'  => 'samsung sm-c900f',
        'sm-c9000'  => 'samsung sm-c9000',
        'sm-g550fy'  => 'samsung sm-g550fy',
        'sm-g532g'  => 'samsung sm-g532g',
        'sm-g532m'  => 'samsung sm-g532m',
        'sm-g485f'  => 'samsung sm-g485f',
        'sm-j327p'  => 'samsung sm-j327p',
        'sm-g750f'  => 'samsung sm-g750f',
        'sm-g7508q' => 'samsung sm-g7508q',
        'sm-g7508'  => 'samsung sm-g7508',
        'sm-p605' => 'sm-p605',
        'sm-p601' => 'sm-p601',
        'sm-p600' => 'sm-p600',
        'sm-p550' => 'sm-p550',
        'sm-p355' => 'sm-p355',
        'sm-p350' => 'sm-p350',
        'sm-n930fd' => 'sm-n930fd',
        'sm-n930f' => 'sm-n930f',
        'sm-n930w8' => 'sm-n930w8',
        'sm-n9300' => 'sm-n9300',
        'sm-n9308' => 'sm-n9308',
        'sm-n930k' => 'sm-n930k',
        'sm-n930l' => 'sm-n930l',
        'sm-n930s' => 'sm-n930s',
        'sm-n930az' => 'sm-n930az',
        'sm-n930a' => 'sm-n930a',
        'sm-n930t1' => 'sm-n930t1',
        'sm-n930t' => 'sm-n930t',
        'sm-n930r6' => 'sm-n930r6',
        'sm-n930r7' => 'sm-n930r7',
        'sm-n930r4' => 'sm-n930r4',
        'sm-n930p' => 'sm-n930p',
        'sm-n930v' => 'sm-n930v',
        'sm-n930u' => 'sm-n930u',
        'sm-n920a' => 'sm-n920a',
        'sm-n920r' => 'sm-n920r',
        'sm-n920s' => 'sm-n920s',
        'sm-n920k' => 'sm-n920k',
        'sm-n920l' => 'sm-n920l',
        'sm-n920g' => 'sm-n920g',
        'sm-n920c' => 'sm-n920c',
        'sm-n920v' => 'sm-n920v',
        'sm-n920t' => 'sm-n920t',
        'sm-n920p' => 'sm-n920p',
        'sm-n920i' => 'sm-n920i',
        'sm-n920w8' => 'sm-n920w8',
        'sm-n9200' => 'sm-n9200',
        'sm-n9208' => 'sm-n9208',
        'sm-n9009' => 'sm-n9009',
        'n9009' => 'sm-n9009',
        'sm-n9008v' => 'sm-n9008v',
        'sm-n9007' => 'sm-n9007',
        'n9007' => 'sm-n9007',
        'sm-n9006' => 'sm-n9006',
        'n9006' => 'sm-n9006',
        'sm-n9005' => 'sm-n9005',
        'n9005' => 'sm-n9005',
        'sm-n9002' => 'sm-n9002',
        'n9002' => 'sm-n9002',
        'sm-n8000' => 'sm-n8000',
        'sm-n7505l' => 'sm-n7505l',
        'sm-n7505' => 'sm-n7505',
        'sm-n7502' => 'sm-n7502',
        'sm-n7500q' => 'sm-n7500q',
        'sm-n750' => 'sm-n750',
        'sm-n916s' => 'sm-n916s',
        'sm-n915fy' => 'sm-n915fy',
        'sm-n915f' => 'sm-n915f',
        'sm-n915t' => 'sm-n915t',
        'sm-n915g' => 'sm-n915g',
        'sm-n915p' => 'sm-n915p',
        'sm-n915a' => 'sm-n915a',
        'sm-n915v' => 'sm-n915v',
        'sm-n915d' => 'sm-n915d',
        'sm-n915k' => 'sm-n915k',
        'sm-n915l' => 'sm-n915l',
        'sm-n915s' => 'sm-n915s',
        'sm-n9150' => 'sm-n9150',
        'sm-n910v' => 'sm-n910v',
        'sm-n910fq' => 'sm-n910fq',
        'sm-n910fd' => 'sm-n910fd',
        'sm-n910f' => 'sm-n910f',
        'sm-n910c' => 'sm-n910c',
        'sm-n910a' => 'sm-n910a',
        'sm-n910h' => 'sm-n910h',
        'sm-n910k' => 'sm-n910k',
        'sm-n910p' => 'sm-n910p',
        'sm-n910x' => 'sm-n910x',
        'sm-n910s' => 'sm-n910s',
        'sm-n910l' => 'sm-n910l',
        'sm-n910g' => 'sm-n910g',
        'sm-n910m' => 'sm-n910m',
        'sm-n910t1' => 'sm-n910t1',
        'sm-n910t3' => 'sm-n910t3',
        'sm-n910t' => 'sm-n910t',
        'sm-n910u' => 'sm-n910u',
        'sm-n910r4' => 'sm-n910r4',
        'sm-n910w8' => 'sm-n910w8',
        'sm-n9100h' => 'sm-n9100h',
        'sm-n9100' => 'sm-n9100',
        'sm-n900v' => 'sm-n900v',
        'sm-n900a' => 'sm-n900a',
        'sm-n900s' => 'sm-n900s',
        'sm-n900t' => 'sm-n900t',
        'sm-n900p' => 'sm-n900p',
        'sm-n900l' => 'sm-n900l',
        'sm-n900k' => 'sm-n900k',
        'sm-n9000q' => 'sm-n9000q',
        'sm-n900w8' => 'sm-n900w8',
        'sm-n900' => 'sm-n900',
        'sm-g935fd' => 'sm-g935fd',
        'sm-g935f' => 'sm-g935f',
        'sm-g935a' => 'sm-g935a',
        'sm-g935p' => 'sm-g935p',
        'sm-g935r' => 'sm-g935r',
        'sm-g935t' => 'sm-g935t',
        'sm-g935v' => 'sm-g935v',
        'sm-g935w8' => 'sm-g935w8',
        'sm-g935k' => 'sm-g935k',
        'sm-g935l' => 'sm-g935l',
        'sm-g935s' => 'sm-g935s',
        'sm-g935x' => 'sm-g935x',
        'sm-g9350' => 'sm-g9350',
        'sm-g930fd' => 'sm-g930fd',
        'sm-g930f' => 'sm-g930f',
        'sm-g9308' => 'sm-g9308',
        'sm-g930a' => 'sm-g930a',
        'sm-g930p' => 'sm-g930p',
        'sm-g930v' => 'sm-g930v',
        'sm-g930r' => 'sm-g930r',
        'sm-g930t' => 'sm-g930t',
        'sm-g930' => 'sm-g930',
        'sm-g928f' => 'sm-g928f',
        'sm-g928v' => 'sm-g928v',
        'sm-g928w8' => 'sm-g928w8',
        'sm-g928c' => 'sm-g928c',
        'sm-g928g' => 'sm-g928g',
        'sm-g928p' => 'sm-g928p',
        'sm-g928i' => 'sm-g928i',
        'sm-g9287' => 'sm-g9287',
        'sm-g925f' => 'sm-g925f',
        'sm-g925t' => 'sm-g925t',
        'sm-g925r4' => 'sm-g925r4',
        'sm-g925i' => 'sm-g925i',
        'sm-g925p' => 'sm-g925p',
        'sm-g925k' => 'sm-g925k',
        'sm-g920k' => 'sm-g920k',
        'sm-g920l' => 'sm-g920l',
        'sm-g920p' => 'sm-g920p',
        'sm-g920v' => 'sm-g920v',
        'sm-g920t1' => 'sm-g920t1',
        'sm-g920t' => 'sm-g920t',
        'sm-g920a' => 'sm-g920a',
        'sm-g920fd' => 'sm-g920fd',
        'sm-g920f' => 'sm-g920f',
        'sm-g920i' => 'sm-g920i',
        'sm-g920s' => 'sm-g920s',
        'sm-g9200' => 'sm-g9200',
        'sm-g9208' => 'sm-g9208',
        'sm-g9209' => 'sm-g9209',
        'sm-g920r' => 'sm-g920r',
        'sm-g920w8' => 'sm-g920w8',
        'sm-g906s' => 'samsung sm-g906s',
        'sm-g903f' => 'sm-g903f',
        'sm-g901f' => 'sm-g901f',
        'sm-g900f' => 'sm-g900f',
        'galaxy s5' => 'sm-g900f',
        'sm-g9006v' => 'sm-g9006v',
        'sm-g900w8' => 'sm-g900w8',
        'sm-g900v' => 'sm-g900v',
        'sm-g900t' => 'sm-g900t',
        'sm-g900i' => 'sm-g900i',
        'sm-g900a' => 'sm-g900a',
        'sm-g900h' => 'sm-g900h',
        'sm-g900' => 'sm-g900',
        'sm-g890a' => 'sm-g890a',
        'sm-g870f' => 'sm-g870f',
        'sm-g870a' => 'sm-g870a',
        'sm-g850fq' => 'sm-g850fq',
        'sm-g850f' => 'sm-g850f',
        'galaxy alpha' => 'sm-g850f',
        'sm-g850a' => 'sm-g850a',
        'sm-g850m' => 'sm-g850m',
        'sm-g850t' => 'sm-g850t',
        'sm-g850w' => 'sm-g850w',
        'sm-g850y' => 'sm-g850y',
        'sm-g800hq' => 'sm-g800hq',
        'sm-g800h' => 'sm-g800h',
        'sm-g800f' => 'sm-g800f',
        'sm-g800m' => 'sm-g800m',
        'sm-g800a' => 'sm-g800a',
        'sm-g800r4' => 'sm-g800r4',
        'sm-g800y' => 'sm-g800y',
        'sm-g720n0' => 'sm-g720n0',
        'sm-g720d' => 'sm-g720d',
        'sm-g7202' => 'sm-g7202',
        'sm-g7102t' => 'sm-g7102t',
        'sm-g7102' => 'sm-g7102',
        'sm-g7105l' => 'sm-g7105l',
        'sm-g7105' => 'sm-g7105',
        'sm-g7106' => 'sm-g7106',
        'sm-g7108v' => 'sm-g7108v',
        'sm-g7108' => 'sm-g7108',
        'sm-g7109' => 'sm-g7109',
        'sm-g710l' => 'sm-g710l',
        'sm-g710' => 'sm-g710',
        'sm-g531f' => 'sm-g531f',
        'sm-g531h' => 'sm-g531h',
        'sm-g530t' => 'sm-g530t',
        'sm-g530h' => 'sm-g530h',
        'sm-g530fz' => 'sm-g530fz',
        'sm-g530f' => 'sm-g530f',
        'sm-g530y' => 'sm-g530y',
        'sm-g530m' => 'sm-g530m',
        'sm-g530bt' => 'sm-g530bt',
        'sm-g5306w' => 'sm-g5306w',
        'sm-g5308w' => 'sm-g5308w',
        'sm-g389f' => 'sm-g389f',
        'sm-g3815' => 'sm-g3815',
        'sm-g388f' => 'sm-g388f',
        'sm-g386t1' => 'samsung sm-g386t1',
        'sm-g386t' => 'samsung sm-g386t',
        'sm-g386f' => 'sm-g386f',
        'sm-g361f' => 'sm-g361f',
        'sm-g361h' => 'sm-g361h',
        'sm-g360hu' => 'sm-g360hu',
        'sm-g360h' => 'sm-g360h',
        'sm-g360t1' => 'sm-g360t1',
        'sm-g360t' => 'sm-g360t',
        'sm-g360bt' => 'sm-g360bt',
        'sm-g360f' => 'sm-g360f',
        'sm-g360g' => 'sm-g360g',
        'sm-g360az' => 'sm-g360az',
        'sm-g357fz' => 'sm-g357fz',
        'sm-g355hq' => 'sm-g355hq',
        'sm-g355hn' => 'sm-g355hn',
        'sm-g355h' => 'sm-g355h',
        'sm-g355m' => 'sm-g355m',
        'sm-g3502l' => 'sm-g3502l',
        'sm-g3502t' => 'sm-g3502t',
        'sm-g3500' => 'sm-g3500',
        'sm-g350e' => 'sm-g350e',
        'sm-g350' => 'sm-g350',
        'sm-g318h' => 'sm-g318h',
        'sm-g313hu' => 'sm-g313hu',
        'sm-g313hn' => 'sm-g313hn',
        'sm-g310hn' => 'sm-g310hn',
        'sm-g130h' => 'sm-g130h',
        'sm-g130e' => 'samsung sm-g130e',
        'sm-g110h' => 'sm-g110h',
        'sm-e700f' => 'sm-e700f',
        'sm-e700h' => 'sm-e700h',
        'sm-e700m' => 'sm-e700m',
        'sm-e7000' => 'sm-e7000',
        'sm-e7009' => 'sm-e7009',
        'sm-e500h' => 'sm-e500h',
        'sm-c115' => 'sm-c115',
        'sm-c111' => 'sm-c111',
        'sm-c105' => 'sm-c105',
        'sm-c101' => 'sm-c101',
        'sm-z130h' => 'sm-z130h',
        'sm-b550h' => 'sm-b550h',
        'sgh-t999' => 'sgh-t999',
        'sgh-t989d' => 'sgh-t989d',
        'sgh-t989' => 'sgh-t989',
        'sgh-t959v' => 'sgh-t959v',
        'sgh-t959' => 'sgh-t959',
        'sgh-t899m' => 'sgh-t899m',
        'sgh-t889' => 'sgh-t889',
        'sgh-t859' => 'sgh-t859',
        'sgh-t839' => 'sgh-t839',
        'sgh-t769' => 'sgh-t769',
        'blaze' => 'sgh-t769',
        'sgh-t759' => 'sgh-t759',
        'sgh-t669' => 'sgh-t669',
        'sgh-t528g' => 'sgh-t528g',
        'sgh-t499' => 'sgh-t499',
        'sgh-t399' => 'samsung sgh-t399',
        'sgh-m919' => 'sgh-m919',
        'sgh-i997r' => 'sgh-i997r',
        'sgh-i997' => 'sgh-i997',
        'sgh-i957r' => 'sgh-i957r',
        'sgh-i957' => 'sgh-i957',
        'sgh-i917' => 'sgh-i917',
        'sgh-i900v' => 'sgh-i900v',
        'sgh-i9000' => 'sgh-i9000',
        'sgh-i9008' => 'sgh-i9008',
        'sgh-i900' => 'sgh-i900',
        'sgh-i897' => 'sgh-i897',
        'sgh-i857' => 'sgh-i857',
        'sgh-i780' => 'sgh-i780',
        'sgh-i777' => 'sgh-i777',
        'sgh-i747m' => 'sgh-i747m',
        'sgh-i747' => 'sgh-i747',
        'sgh-i727r' => 'sgh-i727r',
        'sgh-i727' => 'sgh-i727',
        'sgh-i717' => 'sgh-i717',
        'sgh-i577' => 'sgh-i577',
        'sgh-i547' => 'sgh-i547',
        'sgh-i497' => 'sgh-i497',
        'sgh-i467' => 'sgh-i467',
        'sgh-i337m' => 'sgh-i337m',
        'sgh-i337' => 'sgh-i337',
        'sgh-i317' => 'sgh-i317',
        'sgh-i257' => 'sgh-i257',
        'sgh-f480i' => 'sgh-f480i',
        'sgh-f480' => 'sgh-f480',
        'sgh-e250i' => 'sgh-e250i',
        'sgh-e250' => 'sgh-e250',
        'sgh-b100' => 'sgh-b100',
        'sec-sghb100' => 'sgh-b100',
        'sec-sghu600b' => 'sgh-u600b',
        'sgh-u800e' => 'sgh-u800e',
        'sgh-u800' => 'sgh-u800',
        'shv-e370k' => 'shv-e370k',
        'shv-e250k' => 'shv-e250k',
        'shv-e250l' => 'shv-e250l',
        'shv-e250s' => 'shv-e250s',
        'shv-e210l' => 'shv-e210l',
        'shv-e210k' => 'shv-e210k',
        'shv-e210s' => 'shv-e210s',
        'shv-e160s' => 'shv-e160s',
        'shw-m110s' => 'shw-m110s',
        'shw-m180s' => 'shw-m180s',
        'shw-m380s' => 'shw-m380s',
        'shw-m380w' => 'shw-m380w',
        'shw-m480w' => 'shw-m480w',
        'shw-m380k' => 'shw-m380k',
        'scl24' => 'scl24',
        'sch-u820' => 'sch-u820',
        'sch-u750' => 'sch-u750',
        'sch-u660' => 'sch-u660',
        'sch-u485' => 'sch-u485',
        'sch-r970' => 'sch-r970',
        'sch-r950' => 'sch-r950',
        'sch-r720' => 'sch-r720',
        'sch-r530u' => 'sch-r530u',
        'sch-r530c' => 'sch-r530c',
        'sch-n719' => 'sch-n719',
        'sch-m828c' => 'sch-m828c',
        'sch-i535' => 'sch-i535',
        'sch-i919' => 'sch-i919',
        'sch-i815' => 'sch-i815',
        'sch-i800' => 'sch-i800',
        'sch-i699' => 'sch-i699',
        'sch-i605' => 'sch-i605',
        'sch-i545' => 'sch-i545',
        'sch-i510' => 'sch-i510',
        'sch-i500' => 'sch-i500',
        'sch-i435' => 'sch-i435',
        'sch-i400' => 'sch-i400',
        'sch-i200' => 'sch-i200',
        'sch-s720c' => 'sch-s720c',
        'gt-s8600' => 'gt-s8600',
        'gt-s8530' => 'gt-s8530',
        's8500' => 'gt-s8500',
        'samsung-s8300' => 'gt-s8300',
        'gt-s8300' => 'gt-s8300',
        'samsung-s8003' => 'gt-s8003',
        'gt-s8003' => 'gt-s8003',
        'samsung-s8000' => 'gt-s8000',
        'gt-s8000' => 'gt-s8000',
        'samsung-s7710' => 'gt-s7710',
        'gt-s7710' => 'gt-s7710',
        'gt-s7582' => 'gt-s7582',
        'gt-s7580' => 'gt-s7580',
        'gt-s7562l' => 'gt-s7562l',
        'gt-s7562' => 'gt-s7562',
        'gt-s7560' => 'gt-s7560',
        'gt-s7530l' => 'gt-s7530l',
        'gt-s7530' => 'gt-s7530',
        'gt-s7500' => 'gt-s7500',
        'gt-s7392' => 'gt-s7392',
        'gt-s7390' => 'gt-s7390',
        'gt-s7330' => 'gt-s7330',
        'gt-s7275r' => 'gt-s7275r',
        'gt-s7275' => 'gt-s7275',
        'gt-s7272' => 'gt-s7272',
        'gt-s7270' => 'gt-s7270',
        'gt-s7262' => 'gt-s7262',
        'gt-s7250' => 'gt-s7250',
        'gt-s7233e' => 'gt-s7233e',
        'gt-s7230e' => 'gt-s7230e',
        'samsung-s7220' => 'gt-s7220',
        'gt-s7220' => 'gt-s7220',
        'gt-s6810p' => 'gt-s6810p',
        'gt-s6810b' => 'gt-s6810b',
        'gt-s6810' => 'gt-s6810',
        'gt-s6802' => 'gt-s6802',
        'gt-s6500d' => 'gt-s6500d',
        'gt-s6500t' => 'gt-s6500t',
        'gt-s6500' => 'gt-s6500',
        'gt-s6312' => 'gt-s6312',
        'gt-s6310n' => 'gt-s6310n',
        'gt-s6310' => 'gt-s6310',
        'gt-s6102b' => 'gt-s6102b',
        'gt-s6102' => 'gt-s6102',
        'gt-s5839i' => 'gt-s5839i',
        'gt-s5830l' => 'gt-s5830l',
        'gt-s5830i' => 'gt-s5830i',
        'gt-s5830c' => 'gt-s5830c',
        'gt-s5570i' => 'gt-s5570i',
        'gt-s5570' => 'gt-s5570',
        'gt-s5830' => 'gt-s5830',
        'ace' => 'gt-s5830',
        'gt-s5780' => 'gt-s5780',
        'gt-s5750e' => 'gt-s5750e orange',
        'gt-s5690' => 'gt-s5690',
        'gt-s5670' => 'gt-s5670',
        'gt-s5660' => 'gt-s5660',
        'gt-s5620' => 'gt-s5620',
        'gt-s5560i' => 'gt-s5560i',
        'gt-s5560' => 'gt-s5560',
        'gt-s5380' => 'gt-s5380',
        'gt-s5369' => 'gt-s5369',
        'gt-s5363' => 'gt-s5363',
        'gt-s5360' => 'gt-s5360',
        'gt-s5330' => 'gt-s5330',
    ];

    /**
     * @var \BrowserDetector\Loader\LoaderInterface|null
     */
    private $loader = null;

    /**
     * @param \BrowserDetector\Loader\LoaderInterface $loader
     */
    public function __construct(LoaderInterface $loader)
    {
        $this->loader = $loader;
    }

    /**
     * detects the device name from the given user agent
     *
     * @param string           $useragent
     * @param \Stringy\Stringy $s
     *
     * @return array
     */
    public function detect($useragent, Stringy $s = null)
    {
        foreach ($this->devices as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        if ($s->contains('gt-s5310m', false)) {
            return $this->loader->load('gt-s5310m', $useragent);
        }

        if ($s->contains('gt-s5310', false)) {
            return $this->loader->load('gt-s5310', $useragent);
        }

        if ($s->contains('gt-s5303', false)) {
            return $this->loader->load('samsung gt-s5303', $useragent);
        }

        if ($s->contains('gt-s5302', false)) {
            return $this->loader->load('gt-s5302', $useragent);
        }

        if ($s->contains('gt-s5301l', false)) {
            return $this->loader->load('gt-s5301l', $useragent);
        }

        if ($s->contains('gt-s5301', false)) {
            return $this->loader->load('gt-s5301', $useragent);
        }

        if ($s->contains('gt-s5300b', false)) {
            return $this->loader->load('gt-s5300b', $useragent);
        }

        if ($s->contains('gt-s5300', false)) {
            return $this->loader->load('gt-s5300', $useragent);
        }

        if ($s->contains('gt-s5280', false)) {
            return $this->loader->load('gt-s5280', $useragent);
        }

        if ($s->contains('gt-s5260', false)) {
            return $this->loader->load('gt-s5260', $useragent);
        }

        if ($s->contains('gt-s5250', false)) {
            return $this->loader->load('gt-s5250', $useragent);
        }

        if ($s->contains('gt-s5233s', false)) {
            return $this->loader->load('gt-s5233s', $useragent);
        }

        if ($s->contains('gt-s5230w', false)) {
            return $this->loader->load('gt s5230w', $useragent);
        }

        if ($s->contains('gt-s5230', false)) {
            return $this->loader->load('gt-s5230', $useragent);
        }

        if ($s->contains('gt-s5222r', false)) {
            return $this->loader->load('gt-s5222r', $useragent);
        }

        if ($s->contains('gt-s5222', false)) {
            return $this->loader->load('gt-s5222', $useragent);
        }

        if ($s->contains('gt-s5220', false)) {
            return $this->loader->load('gt-s5220', $useragent);
        }

        if ($s->contains('gt-s3850', false)) {
            return $this->loader->load('gt-s3850', $useragent);
        }

        if ($s->contains('gt-s3802', false)) {
            return $this->loader->load('gt-s3802', $useragent);
        }

        if ($s->contains('gt-s3653', false)) {
            return $this->loader->load('gt-s3653', $useragent);
        }

        if ($s->contains('gt-s3650', false)) {
            return $this->loader->load('gt-s3650', $useragent);
        }

        if ($s->contains('gt-s3370', false)) {
            return $this->loader->load('gt-s3370', $useragent);
        }

        if ($s->contains('gt-p7511', false)) {
            return $this->loader->load('gt-p7511', $useragent);
        }

        if ($s->contains('gt-p7510', false)) {
            return $this->loader->load('gt-p7510', $useragent);
        }

        if ($s->contains('gt-p7501', false)) {
            return $this->loader->load('gt-p7501', $useragent);
        }

        if ($s->contains('gt-p7500m', false)) {
            return $this->loader->load('gt-p7500m', $useragent);
        }

        if ($s->contains('gt-p7500', false)) {
            return $this->loader->load('gt-p7500', $useragent);
        }

        if ($s->contains('gt-p7320', false)) {
            return $this->loader->load('gt-p7320', $useragent);
        }

        if ($s->contains('gt-p7310', false)) {
            return $this->loader->load('gt-p7310', $useragent);
        }

        if ($s->contains('gt-p7300b', false)) {
            return $this->loader->load('gt-p7300b', $useragent);
        }

        if ($s->contains('gt-p7300', false)) {
            return $this->loader->load('gt-p7300', $useragent);
        }

        if ($s->contains('gt-p7100', false)) {
            return $this->loader->load('gt-p7100', $useragent);
        }

        if ($s->contains('gt-p6810', false)) {
            return $this->loader->load('gt-p6810', $useragent);
        }

        if ($s->contains('gt-p6800', false)) {
            return $this->loader->load('gt-p6800', $useragent);
        }

        if ($s->contains('gt-p6211', false)) {
            return $this->loader->load('gt-p6211', $useragent);
        }

        if ($s->contains('gt-p6210', false)) {
            return $this->loader->load('gt-p6210', $useragent);
        }

        if ($s->contains('gt-p6201', false)) {
            return $this->loader->load('gt-p6201', $useragent);
        }

        if ($s->contains('gt-p6200', false)) {
            return $this->loader->load('gt-p6200', $useragent);
        }

        if ($s->contains('gt-p5220', false)) {
            return $this->loader->load('gt-p5220', $useragent);
        }

        if ($s->contains('gt-p5210', false)) {
            return $this->loader->load('gt-p5210', $useragent);
        }

        if ($s->contains('gt-p5200', false)) {
            return $this->loader->load('gt-p5200', $useragent);
        }

        if ($s->contains('gt-p5113', false)) {
            return $this->loader->load('gt-p5113', $useragent);
        }

        if ($s->contains('gt-p5110', false)) {
            return $this->loader->load('gt-p5110', $useragent);
        }

        if ($s->contains('gt-p5100', false)) {
            return $this->loader->load('gt-p5100', $useragent);
        }

        if ($s->contains('gt-p3113', false)) {
            return $this->loader->load('gt-p3113', $useragent);
        }

        if ($s->containsAny(['gt-p3100', 'galaxy tab 2 3g'], false)) {
            return $this->loader->load('gt-p3100', $useragent);
        }

        if ($s->containsAny(['gt-p3110', 'galaxy tab 2'], false)) {
            return $this->loader->load('gt-p3110', $useragent);
        }

        if ($s->contains('gt-p1010', false)) {
            return $this->loader->load('gt-p1010', $useragent);
        }

        if ($s->contains('gt-p1000n', false)) {
            return $this->loader->load('gt-p1000n', $useragent);
        }

        if ($s->contains('gt-p1000m', false)) {
            return $this->loader->load('gt-p1000m', $useragent);
        }

        if ($s->contains('gt-p1000', false)) {
            return $this->loader->load('gt-p1000', $useragent);
        }

        if ($s->contains('gt-n9000', false)) {
            return $this->loader->load('gt-n9000', $useragent);
        }

        if ($s->contains('gt-n8020', false)) {
            return $this->loader->load('gt-n8020', $useragent);
        }

        if ($s->contains('gt-n8013', false)) {
            return $this->loader->load('gt-n8013', $useragent);
        }

        if ($s->contains('gt-n8010', false)) {
            return $this->loader->load('gt-n8010', $useragent);
        }

        if ($s->contains('gt-n8005', false)) {
            return $this->loader->load('gt-n8005', $useragent);
        }

        if ($s->containsAny(['gt-n8000d', 'n8000d'], false)) {
            return $this->loader->load('gt-n8000d', $useragent);
        }

        if ($s->contains('gt-n8000', false)) {
            return $this->loader->load('gt-n8000', $useragent);
        }

        if ($s->contains('gt-n7108', false)) {
            return $this->loader->load('gt-n7108', $useragent);
        }

        if ($s->contains('gt-n7105', false)) {
            return $this->loader->load('gt-n7105', $useragent);
        }

        if ($s->contains('gt-n7100', false)) {
            return $this->loader->load('gt-n7100', $useragent);
        }

        if ($s->contains('GT-N7000', false)) {
            return $this->loader->load('gt-n7000', $useragent);
        }

        if ($s->contains('GT-N5120', false)) {
            return $this->loader->load('gt-n5120', $useragent);
        }

        if ($s->contains('GT-N5110', false)) {
            return $this->loader->load('gt-n5110', $useragent);
        }

        if ($s->contains('GT-N5100', false)) {
            return $this->loader->load('gt-n5100', $useragent);
        }

        if ($s->containsAny(['gt-m7603', 'samsung-m7603'], false)) {
            return $this->loader->load('gt-m7603', $useragent);
        }

        if ($s->contains('gt-m7600l', false)) {
            return $this->loader->load('gt-m7600l', $useragent);
        }

        if ($s->containsAny(['gt-m7600', 'samsung-m7600'], false)) {
            return $this->loader->load('gt-m7600', $useragent);
        }

        if ($s->contains('GT-I9515', false)) {
            return $this->loader->load('gt-i9515', $useragent);
        }

        if ($s->contains('GT-I9506', false)) {
            return $this->loader->load('gt-i9506', $useragent);
        }

        if ($s->contains('GT-I9505X', false)) {
            return $this->loader->load('gt-i9505x', $useragent);
        }

        if ($s->contains('GT-I9505G', false)) {
            return $this->loader->load('gt-i9505g', $useragent);
        }

        if ($s->contains('GT-I9505', false)) {
            return $this->loader->load('gt-i9505', $useragent);
        }

        if ($s->contains('GT-I9502', false)) {
            return $this->loader->load('gt-i9502', $useragent);
        }

        if ($s->contains('GT-I9500', false)) {
            return $this->loader->load('gt-i9500', $useragent);
        }

        if ($s->contains('GT-I9308', false)) {
            return $this->loader->load('gt-i9308', $useragent);
        }

        if ($s->contains('GT-I9305', false)) {
            return $this->loader->load('gt-i9305', $useragent);
        }

        if ($s->containsAny(['gt-i9301i', 'i9301i'], false)) {
            return $this->loader->load('gt-i9301i', $useragent);
        }

        if ($s->containsAny(['gt-i9301q', 'i9301q'], false)) {
            return $this->loader->load('gt-i9301q', $useragent);
        }

        if ($s->containsAny(['gt-i9301', 'i9301'], false)) {
            return $this->loader->load('gt-i9301', $useragent);
        }

        if ($s->contains('GT-I9300I', false)) {
            return $this->loader->load('gt-i9300i', $useragent);
        }

        if ($s->containsAny(['GT-l9300', 'GT-i9300', 'I9300'], false)) {
            return $this->loader->load('gt-i9300', $useragent);
        }

        if ($s->containsAny(['GT-I9295', 'I9295'], false)) {
            return $this->loader->load('gt-i9295', $useragent);
        }

        if ($s->contains('GT-I9210', false)) {
            return $this->loader->load('gt-i9210', $useragent);
        }

        if ($s->contains('GT-I9205', false)) {
            return $this->loader->load('gt-i9205', $useragent);
        }

        if ($s->contains('GT-I9200', false)) {
            return $this->loader->load('gt-i9200', $useragent);
        }

        if ($s->contains('gt-i9195i', false)) {
            return $this->loader->load('gt-i9195i', $useragent);
        }

        if ($s->containsAny(['gt-i9195', 'i9195'], false)) {
            return $this->loader->load('gt-i9195', $useragent);
        }

        if ($s->containsAny(['gt-i9192', 'i9192'], false)) {
            return $this->loader->load('gt-i9192', $useragent);
        }

        if ($s->containsAny(['gt-i9190', 'i9190'], false)) {
            return $this->loader->load('gt-i9190', $useragent);
        }

        if ($s->contains('gt-i9152', false)) {
            return $this->loader->load('gt-i9152', $useragent);
        }

        if ($s->contains('gt-i9128v', false)) {
            return $this->loader->load('gt-i9128v', $useragent);
        }

        if ($s->contains('gt-i9105p', false)) {
            return $this->loader->load('gt-i9105p', $useragent);
        }

        if ($s->contains('gt-i9105', false)) {
            return $this->loader->load('gt-i9105', $useragent);
        }

        if ($s->contains('gt-i9103', false)) {
            return $this->loader->load('gt-i9103', $useragent);
        }

        if ($s->contains('gt-i9100t', false)) {
            return $this->loader->load('gt-i9100t', $useragent);
        }

        if ($s->contains('gt-i9100p', false)) {
            return $this->loader->load('gt-i9100p', $useragent);
        }

        if ($s->contains('gt-i9100g', false)) {
            return $this->loader->load('gt-i9100g', $useragent);
        }

        if ($s->containsAny(['gt-i9100', 'i9100', 'galaxy s ii'], false)) {
            return $this->loader->load('gt-i9100', $useragent);
        }

        if ($s->contains('gt-i9088', false)) {
            return $this->loader->load('gt-i9088', $useragent);
        }

        if ($s->contains('gt-i9082l', false)) {
            return $this->loader->load('gt-i9082l', $useragent);
        }

        if ($s->contains('gt-i9082', false)) {
            return $this->loader->load('gt-i9082', $useragent);
        }

        if ($s->contains('gt-i9070p', false)) {
            return $this->loader->load('gt-i9070p', $useragent);
        }

        if ($s->contains('gt-i9070', false)) {
            return $this->loader->load('gt-i9070', $useragent);
        }

        if ($s->contains('gt-i9060l', false)) {
            return $this->loader->load('gt-i9060l', $useragent);
        }

        if ($s->contains('gt-i9060i', false)) {
            return $this->loader->load('gt-i9060i', $useragent);
        }

        if ($s->contains('gt-i9060', false)) {
            return $this->loader->load('gt-i9060', $useragent);
        }

        if ($s->contains('gt-i9023', false)) {
            return $this->loader->load('gt-i9023', $useragent);
        }

        if ($s->containsAny(['galaxy s4', 'galaxy-s4', 'galaxys4'], false)) {
            return $this->loader->load('gt-i9500', $useragent);
        }

        if ($s->contains('galaxy s iv', false)) {
            return $this->loader->load('gt-i950x', $useragent);
        }

        if ($s->containsAny(['galaxy s', 'galaxy-s', 'gt-i9010'], false)) {
            return $this->loader->load('samsung gt-i9010', $useragent);
        }

        if ($s->contains('gt-i9008l', false)) {
            return $this->loader->load('gt-i9008l', $useragent);
        }

        if ($s->contains('gt-i9008', false)) {
            return $this->loader->load('gt-i9008', $useragent);
        }

        if ($s->contains('gt-i9003l', false)) {
            return $this->loader->load('gt-i9003l', $useragent);
        }

        if ($s->contains('gt-i9003', false)) {
            return $this->loader->load('gt-i9003', $useragent);
        }

        if ($s->contains('gt-i9001', false)) {
            return $this->loader->load('gt-i9001', $useragent);
        }

        if ($s->containsAny(['gt-i9000', 'sgh-t959v'], false)) {
            return $this->loader->load('gt-i9000', $useragent);
        }

        if ($s->containsAny(['gt-i8910', 'i8910'], false)) {
            return $this->loader->load('gt-i8910', $useragent);
        }

        if ($s->contains('gt-i8750', false)) {
            return $this->loader->load('gt-i8750', $useragent);
        }

        if ($s->contains('gt-i8730', false)) {
            return $this->loader->load('gt-i8730', $useragent);
        }

        if ($s->contains('omnia7', false)) {
            return $this->loader->load('gt-i8700', $useragent);
        }

        if ($s->contains('gt-i8552', false)) {
            return $this->loader->load('gt-i8552', $useragent);
        }

        if ($s->contains('gt-i8530', false)) {
            return $this->loader->load('gt-i8530', $useragent);
        }

        if ($s->contains('gt-i8350', false)) {
            return $this->loader->load('gt-i8350', $useragent);
        }

        if ($s->contains('gt-i8320', false)) {
            return $this->loader->load('gt-i8320', $useragent);
        }

        if ($s->contains('gt-i8262', false)) {
            return $this->loader->load('gt-i8262', $useragent);
        }

        if ($s->contains('gt-i8260', false)) {
            return $this->loader->load('gt-i8260', $useragent);
        }

        if ($s->contains('gt-i8200n', false)) {
            return $this->loader->load('gt-i8200n', $useragent);
        }

        if ($s->contains('GT-I8200', false)) {
            return $this->loader->load('gt-i8200', $useragent);
        }

        if ($s->contains('GT-I8190N', false)) {
            return $this->loader->load('gt-i8190n', $useragent);
        }

        if ($s->contains('GT-I8190', false)) {
            return $this->loader->load('gt-i8190', $useragent);
        }

        if ($s->contains('GT-I8160P', false)) {
            return $this->loader->load('gt-i8160p', $useragent);
        }

        if ($s->contains('GT-I8160', false)) {
            return $this->loader->load('gt-i8160', $useragent);
        }

        if ($s->contains('GT-I8150', false)) {
            return $this->loader->load('gt-i8150', $useragent);
        }

        if ($s->contains('GT-i8000V', false)) {
            return $this->loader->load('gt-i8000v', $useragent);
        }

        if ($s->contains('GT-i8000', false)) {
            return $this->loader->load('gt-i8000', $useragent);
        }

        if ($s->contains('GT-I6410', false)) {
            return $this->loader->load('gt-i6410', $useragent);
        }

        if ($s->contains('GT-I5801', false)) {
            return $this->loader->load('gt-i5801', $useragent);
        }

        if ($s->contains('GT-I5800', false)) {
            return $this->loader->load('gt-i5800', $useragent);
        }

        if ($s->contains('GT-I5700', false)) {
            return $this->loader->load('gt-i5700', $useragent);
        }

        if ($s->contains('GT-I5510', false)) {
            return $this->loader->load('gt-i5510', $useragent);
        }

        if ($s->contains('GT-I5508', false)) {
            return $this->loader->load('gt-i5508', $useragent);
        }

        if ($s->contains('GT-I5503', false)) {
            return $this->loader->load('gt-i5503', $useragent);
        }

        if ($s->contains('GT-I5500', false)) {
            return $this->loader->load('gt-i5500', $useragent);
        }

        if ($s->contains('nexus s 4g', false)) {
            return $this->loader->load('nexus s 4g', $useragent);
        }

        if ($s->contains('nexus s', false)) {
            return $this->loader->load('nexus s', $useragent);
        }

        if ($s->contains('nexus 10', false)) {
            return $this->loader->load('nexus 10', $useragent);
        }

        if ($s->contains('nexus player', false)) {
            return $this->loader->load('nexus player', $useragent);
        }

        if ($s->contains('nexus', false)) {
            return $this->loader->load('galaxy nexus', $useragent);
        }

        if ($s->contains('Galaxy', false)) {
            return $this->loader->load('gt-i7500', $useragent);
        }

        if ($s->contains('GT-E3309T', false)) {
            return $this->loader->load('gt-e3309t', $useragent);
        }

        if ($s->contains('gt-e2550l', false)) {
            return $this->loader->load('gt-e2550l', $useragent);
        }

        if ($s->contains('gt-e2550', false)) {
            return $this->loader->load('gt-e2550', $useragent);
        }

        if ($s->contains('GT-E2252', false)) {
            return $this->loader->load('gt-e2252', $useragent);
        }

        if ($s->contains('GT-E2222L', false)) {
            return $this->loader->load('gt-e2222l', $useragent);
        }

        if ($s->contains('GT-E2222', false)) {
            return $this->loader->load('gt-e2222', $useragent);
        }

        if ($s->contains('GT-E2202', false)) {
            return $this->loader->load('gt-e2202', $useragent);
        }

        if ($s->contains('GT-E1282T', false)) {
            return $this->loader->load('gt-e1282t', $useragent);
        }

        if ($s->contains('GT-C6712', false)) {
            return $this->loader->load('gt-c6712', $useragent);
        }

        if ($s->contains('GT-C3780', false)) {
            return $this->loader->load('gt-c3780', $useragent);
        }

        if ($s->contains('GT-C3510', false)) {
            return $this->loader->load('gt-c3510', $useragent);
        }

        if ($s->contains('GT-C3500', false)) {
            return $this->loader->load('gt-c3500', $useragent);
        }

        if ($s->contains('GT-C3350', false)) {
            return $this->loader->load('gt-c3350', $useragent);
        }

        if ($s->contains('GT-C3322', false)) {
            return $this->loader->load('gt-c3322', $useragent);
        }

        if ($s->contains('gt-C3312r', false)) {
            return $this->loader->load('gt-c3312r', $useragent);
        }

        if ($s->contains('GT-C3310', false)) {
            return $this->loader->load('gt-c3310', $useragent);
        }

        if ($s->contains('GT-C3262', false)) {
            return $this->loader->load('gt-c3262', $useragent);
        }

        if ($s->contains('GT-B7722', false)) {
            return $this->loader->load('gt-b7722', $useragent);
        }

        if ($s->contains('GT-B7610', false)) {
            return $this->loader->load('gt-b7610', $useragent);
        }

        if ($s->contains('gt-b7510l', false)) {
            return $this->loader->load('gt-b7510l', $useragent);
        }

        if ($s->contains('gt-b7510', false)) {
            return $this->loader->load('gt-b7510', $useragent);
        }

        if ($s->contains('GT-B7350', false)) {
            return $this->loader->load('gt-b7350', $useragent);
        }

        if ($s->contains('gt-b5510l', false)) {
            return $this->loader->load('gt-b5510l', $useragent);
        }

        if ($s->contains('gt-b5510', false)) {
            return $this->loader->load('gt-b5510', $useragent);
        }

        if ($s->contains('gt-b3410', false)) {
            return $this->loader->load('gt-b3410', $useragent);
        }

        if ($s->contains('gt-b2710', false)) {
            return $this->loader->load('gt-b2710', $useragent);
        }

        if ($s->contains('gt-b2100i', false)) {
            return $this->loader->load('gt-b2100i', $useragent);
        }

        if ($s->containsAny(['gt-b2100', 'b2100'], false)) {
            return $this->loader->load('gt-b2100', $useragent);
        }

        if ($s->contains('F031', false)) {
            return $this->loader->load('f031', $useragent);
        }

        if ($s->contains('Continuum-I400', false)) {
            return $this->loader->load('continuum i400', $useragent);
        }

        if ($s->contains('CETUS', false)) {
            return $this->loader->load('cetus', $useragent);
        }

        if ($s->contains('sc-06d', false)) {
            return $this->loader->load('sc-06d', $useragent);
        }

        if ($s->contains('sc-02f', false)) {
            return $this->loader->load('sc-02f', $useragent);
        }

        if ($s->contains('sc-02c', false)) {
            return $this->loader->load('sc-02c', $useragent);
        }

        if ($s->contains('sc-02b', false)) {
            return $this->loader->load('sc-02b', $useragent);
        }

        if ($s->contains('sc-01f', false)) {
            return $this->loader->load('sc-01f', $useragent);
        }

        if ($s->contains('S3500', false)) {
            return $this->loader->load('s3500', $useragent);
        }

        if ($s->contains('R631', false)) {
            return $this->loader->load('r631', $useragent);
        }

        if ($s->contains('i7110', false)) {
            return $this->loader->load('i7110', $useragent);
        }

        if ($s->contains('yp-gs1', false)) {
            return $this->loader->load('yp-gs1', $useragent);
        }

        if ($s->contains('yp-gi1', false)) {
            return $this->loader->load('yp-gi1', $useragent);
        }

        if ($s->contains('yp-gb70', false)) {
            return $this->loader->load('yp-gb70', $useragent);
        }

        if ($s->contains('yp-g70', false)) {
            return $this->loader->load('yp-g70', $useragent);
        }

        if ($s->contains('yp-g1', false)) {
            return $this->loader->load('yp-g1', $useragent);
        }

        if ($s->contains('sch-r730', false)) {
            return $this->loader->load('sch-r730', $useragent);
        }

        if ($s->contains('sph-p100', false)) {
            return $this->loader->load('sph-p100', $useragent);
        }

        if ($s->contains('sph-m930bst', false)) {
            return $this->loader->load('sph-m930bst', $useragent);
        }

        if ($s->contains('sph-m930', false)) {
            return $this->loader->load('sph-m930', $useragent);
        }

        if ($s->contains('sph-m840', false)) {
            return $this->loader->load('sph-m840', $useragent);
        }

        if ($s->contains('sph-m580bst', false)) {
            return $this->loader->load('sph-m580bst', $useragent);
        }

        if ($s->contains('sph-m580', false)) {
            return $this->loader->load('sph-m580', $useragent);
        }

        if ($s->contains('sph-l900', false)) {
            return $this->loader->load('sph-l900', $useragent);
        }

        if ($s->contains('sph-l720', false)) {
            return $this->loader->load('sph-l720', $useragent);
        }

        if ($s->contains('sph-l710', false)) {
            return $this->loader->load('sph-l710', $useragent);
        }

        if ($s->contains('sph-ip830w', false)) {
            return $this->loader->load('sph-ip830w', $useragent);
        }

        if ($s->contains('sph-d710bst', false)) {
            return $this->loader->load('sph-d710bst', $useragent);
        }

        if ($s->contains('sph-d710', false)) {
            return $this->loader->load('sph-d710', $useragent);
        }

        if ($s->contains('smart-tv', false)) {
            return $this->loader->load('samsung smart tv', $useragent);
        }

        return $this->loader->load('general samsung device', $useragent);
    }
}
