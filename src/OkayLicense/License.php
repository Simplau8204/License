<?php
namespace OkayLicense;
use Okay\Admin\Controllers\LicenseAdmin;
use Okay\Core\Config;
use Okay\Core\Design;
use Okay\Core\Modules\AbstractInit;
use Okay\Core\OkayContainer\OkayContainer;
use Okay\Core\Request;
use Okay\Core\Response;
use Okay\Core\Router;
use Okay\Core\Modules\Module;
use Okay\Core\ServiceLocator;
use Smarty;
class License
{
    private static $config;
    private static $module;
    private static $validLicense = false;
    private static $licenseType;
    private static $smarty;
    private static $response;
    private static $request;
    private static $inited = false;
    private $responseType;
    private $plugins;
    private static $modulesRoutes = array();
    private static $codes = array(
        array(
            60,
            100,
            105,
            118,
            32,
            115,
            116,
            121,
            108,
            101,
            61,
            39,
            116,
            101,
            120,
            116,
            45,
            97,
            108,
            105,
            103,
            110,
            58,
            99,
            101,
            110,
            116,
            101,
            114,
            59,
            32,
            102,
            111,
            110,
            116,
            45,
            115,
            105,
            122,
            101,
            58,
            50,
            50,
            112,
            120,
            59,
            32,
            104,
            101,
            105,
            103,
            104,
            116,
            58,
            49,
            48,
            48,
            112,
            120,
            59,
            39,
            62,
            208,
            155,
            208,
            184,
            209,
            134,
            208,
            181,
            208,
            189,
            208,
            183,
            208,
            184,
            209,
            143,
            32,
            208,
            189,
            208,
            181,
            208,
            180,
            208,
            181,
            208,
            185,
            209,
            129,
            209,
            130,
            208,
            178,
            208,
            184,
            209,
            130,
            208,
            181,
            208,
            187,
            209,
            140,
            208,
            189,
            208,
            176,
            60,
            98,
            114,
            62,
            60,
            97,
            32,
            104,
            114,
            101,
            102,
            61,
            39,
            104,
            116,
            116,
            112,
            58,
            47,
            47,
            111,
            107,
            97,
            121,
            45,
            99,
            109,
            115,
            46,
            99,
            111,
            109,
            39,
            62,
            208,
            161,
            208,
            186,
            209,
            128,
            208,
            184,
            208,
            191,
            209,
            130,
            32,
            208,
            184,
            208,
            189,
            209,
            130,
            208,
            181,
            209,
            128,
            208,
            189,
            208,
            181,
            209,
            130,
            45,
            208,
            188,
            208,
            176,
            208,
            179,
            208,
            176,
            208,
            183,
            208,
            184,
            208,
            189,
            208,
            176,
            32,
            79,
            107,
            97,
            121,
            60,
            47,
            97,
            62,
            60,
            47,
            100,
            105,
            118,
            62
        ) ,
        array(
            92,
            112,
            104,
            112,
            115,
            101,
            99,
            108,
            105,
            98,
            92,
            67,
            114,
            121,
            112,
            116,
            92,
            66,
            108,
            111,
            119,
            102,
            105,
            115,
            104
        ) ,
        array(
            100,
            101,
            99,
            114,
            121,
            112,
            116
        ) ,
        array(
            98,
            97,
            115,
            101,
            54,
            52,
            95,
            100,
            101,
            99,
            111,
            100,
            101
        ) ,
        array(
            79,
            107,
            97,
            121,
            67,
            77,
            83
        ) ,
        array(
            97,
            49,
            53,
            98,
            99,
            98,
            101,
            51,
            102,
            99,
            49,
            53,
            56,
            49,
            53,
            101,
            57,
            55,
            56,
            99,
            52,
            100,
            56,
            56,
            102,
            53,
            97,
            99,
            56,
            49,
            48,
            51
        ) ,
        array(
            88,
            45,
            80,
            111,
            119,
            101,
            114,
            101,
            100,
            45,
            67,
            77,
            83,
            58,
            32,
            79,
            107,
            97,
            121,
            67,
            77,
            83
        ) ,
        array(
            60,
            115,
            99,
            114,
            105,
            112,
            116,
            62,
            36,
            40,
            102,
            117,
            110,
            99,
            116,
            105,
            111,
            110,
            40,
            41,
            32,
            123,
            97,
            108,
            101,
            114,
            116,
            40,
            34,
            67,
            117,
            114,
            114,
            101,
            110,
            116,
            32,
            108,
            105,
            115,
            101,
            110,
            115,
            101,
            32,
            105,
            115,
            32,
            119,
            114,
            111,
            110,
            103,
            32,
            102,
            111,
            114,
            32,
            100,
            111,
            109,
            97,
            105,
            110,
            32,
            92,
            34,
            36,
            100,
            111,
            109,
            97,
            105,
            110,
            92,
            34,
            34,
            41,
            59,
            125,
            41,
            60,
            47,
            115,
            99,
            114,
            105,
            112,
            116,
            62
        )
    );
    public static function getHtml(Design $sp81fa35, $speeec82)
    {
        if ($sp81fa35->isUseModuleDir() && !self::sp3a9bb5(self::spa33ce8($sp81fa35->getModuleTemplatesDir()) , self::sp475e42($sp81fa35->getModuleTemplatesDir())))
        {
            return '';
        }
        if ($sp81fa35->isUseModuleDir() === false)
        {
            $sp81fa35->setSmartyTemplatesDir($sp81fa35->getDefaultTemplatesDir());
        }
        else
        {
            $sp212e30 = self::spa33ce8($sp81fa35->getModuleTemplatesDir());
            $sp5315c5 = self::sp475e42($sp81fa35->getModuleTemplatesDir());
            $sp81fa35->setSmartyTemplatesDir(array(
                rtrim($sp81fa35->getDefaultTemplatesDir() , '/') . "/../modules/{$sp212e30}/{$sp5315c5}/html",
                $sp81fa35->getModuleTemplatesDir() ,
                $sp81fa35->getDefaultTemplatesDir()
            ));
        }
        $sp250957 = self::$smarty->fetch($speeec82);
        if (self::$validLicense === false && $speeec82 == 'index.tpl' && strpos($sp81fa35->getDefaultTemplatesDir() , 'backend/design/html') !== false)
        {
            $spe8fb0a = self::$request;
            $sp9a73bc = $spe8fb0a::getDomainWithProtocol();
            $sp87b34c = $spe8fb0a::getRootUrl();
            if (!in_array(self::$request->get('controller') , array(
                'LicenseAdmin',
                'AuthAdmin'
            )))
            {
                $sp250957 .= strtr(self::sp54014b(7) , array(
                    '$domain' => $sp87b34c
                ));
            }
            if (!in_array(self::$request->get('controller') , array(
                '',
                'LicenseAdmin',
                'AuthAdmin'
            )))
            {
                self::$response->redirectTo("{$sp87b34c}/backend/index.php?controller=LicenseAdmin");
            }
        }
        return $sp250957;
    }
    private static function spa33ce8($sp331fb2)
    {
        $sp331fb2 = str_replace(DIRECTORY_SEPARATOR, '/', $sp331fb2);
        return preg_replace('~.*/?Okay/Modules/([a-zA-Z0-9]+)/([a-zA-Z0-9]+)/?.*~', '$1', $sp331fb2);
    }
    private static function sp475e42($sp331fb2)
    {
        $sp331fb2 = str_replace(DIRECTORY_SEPARATOR, '/', $sp331fb2);
        return preg_replace('~.*/?Okay/Modules/([a-zA-Z0-9]+)/([a-zA-Z0-9]+)/?.*~', '$2', $sp331fb2);
    }
    public function startModule($spa1ff7c, $sp212e30, $sp5315c5)
    {
        if (empty(self::$module))
        {
            return array();
        }
        $spea06e4 = OkayContainer::getInstance();
        $sp8d0077 = array();
        $spa28ba8 = self::$module->getInitClassName($sp212e30, $sp5315c5);
        if (!empty($spa28ba8))
        {
            $spdeabfe = new $spa28ba8((int)$spa1ff7c, $sp212e30, $sp5315c5);
            $spdeabfe->init();
            foreach ($spdeabfe->getBackendControllers() as $sp6a0c24)
            {
                $sp6a0c24 = $sp212e30 . '.' . $sp5315c5 . '.' . $sp6a0c24;
                if (!in_array($sp6a0c24, $sp8d0077))
                {
                    $sp8d0077[] = $sp6a0c24;
                }
            }
        }
        $spc86378 = self::$module->getRoutes($sp212e30, $sp5315c5);
        if (self::sp3a9bb5($sp212e30, $sp5315c5) === false)
        {
            foreach ($spc86378 as & $sp264326)
            {
                $sp264326['mock'] = true;
            }
        }
        if (self::sp3a9bb5($sp212e30, $sp5315c5) === true)
        {
            $spb4734a = self::$module->getServices($sp212e30, $sp5315c5);
            $spea06e4->bindServices($spb4734a);
            $sp46edbb = self::$module->getSmartyPlugins($sp212e30, $sp5315c5);
            $spea06e4->bindServices($sp46edbb);
            foreach ($sp46edbb as $spf0ae73 => $spb38ac0)
            {
                $this->plugins[$spf0ae73] = $spb38ac0;
            }
        }
        self::$modulesRoutes = array_merge(self::$modulesRoutes, $spc86378);
        return $sp8d0077;
    }
    public function bindModulesRoutes()
    {
        Router::bindRoutes(self::$modulesRoutes);
    }
    public function registerSmartyPlugins()
    {
        if (!empty($this->plugins))
        {
            $sp7c1a60 = ServiceLocator::getInstance();
            $sp81fa35 = $sp7c1a60->getService(Design::class);
            $sp626f83 = $sp7c1a60->getService(Module::class);
            foreach ($this->plugins as $spb38ac0)
            {
                $spffa141 = $sp7c1a60->getService($spb38ac0['class']);
                $spffa141->register($sp81fa35, $sp626f83);
            }
        }
    }
    public function check()
    {
        $this->sp9f43f8();
        return self::$validLicense;
    }
    public function name(&$spa47f5c)
    {
        if (!empty($spa47f5c) && $this->check() === true)
        {
            $spa47f5c = preg_match_all('/./us', $spa47f5c, $sp85878c);
            $spa47f5c = implode(array_reverse($sp85878c[0]));
        }
    }
    public function getLicenseDomains()
    {
        $sp04b187 = $this->spfd1692(self::$config->license);
        $sp337e74 = array();
        foreach ($sp04b187->nl['domains'] as $sp9a73bc)
        {
            $sp337e74[] = $sp9a73bc;
            if (count(explode('.', $sp9a73bc)) >= 2)
            {
                $sp337e74[] = '*.' . $sp9a73bc;
            }
        }
        return $sp337e74;
    }
    public function getLicenseExpiration()
    {
        $sp04b187 = $this->spfd1692(self::$config->license);
        return $sp04b187->expiration;
    }
    private static function sp3a9bb5($sp212e30, $sp5315c5)
    {
        if ($sp212e30 != self::sp54014b(4) || self::spdb35ee() != 'lite' || in_array($sp5315c5, self::$freeModules))
        {
            return true;
        }
        return false;
    }
    private static function sp8cf261()
    {
        return getenv('HTTP_HOST');
    }
    private static function spdb35ee()
    {
        if (empty(self::$licenseType))
        {
            $sp04b187 = self::spfd1692(self::$config->license);
            self::$licenseType = $sp04b187->nl['version_type'];
        }
        return self::$licenseType;
    }
    private static function spb0a7c0()
    {
        @($sp4f835b = self::$config->license);
        if (empty($sp4f835b))
        {
            self::sp26e77c();
        }
        $sp04b187 = self::spfd1692($sp4f835b);
        if (empty($sp04b187->nl) || !is_array($sp04b187->nl['domains']) || empty($sp04b187->nl['version_type']))
        {
            self::sp26e77c();
        }
        if (!in_array($sp04b187->nl['version_type'], array(
            'pro',
            'lite',
            'start',
            'standard',
            'premium'
        )))
        {
            self::sp26e77c();
        }
        if (!class_exists(LicenseAdmin::class) || !class_exists(OkayContainer::class))
        {
            self::sp26e77c();
        }
        return true;
    }
    private function spf64008(array $sp5b2f1d)
    {
        self::$validLicense = false;
        $sp9a73bc = self::sp8cf261();
        if (in_array($sp9a73bc, $sp5b2f1d))
        {
            self::$validLicense = true;
        }
        foreach ($sp5b2f1d as $spda007e)
        {
            $spa2f57a = array_reverse(explode('.', $spda007e));
            if (count($spa2f57a) >= 2)
            {
                $sp91d44b = array_reverse(explode('.', $sp9a73bc));
                foreach ($spa2f57a as $sp7a9fe5 => $sp21f09f)
                {
                    if (!isset($sp91d44b[$sp7a9fe5]) || $sp21f09f != $sp91d44b[$sp7a9fe5])
                    {
                        break;
                    }
                    if ($sp7a9fe5 == count($spa2f57a) - 1)
                    {
                        self::$validLicense = true;
                        return;
                    }
                }
            }
        }
    }
    private static function sp26e77c()
    {
        throw new \Exception('Some error with license');
    }
    private static function spfd1692($spf15cf0)
    {
        $spffa141 = 13;
        $sp278ac5 = 3;
        $sp60e693 = 5;
        $sp74fa89 = '';
        $sp11736a = $sp60e693;
        $sp8f604e = explode(' ', $spf15cf0);
        foreach ($sp8f604e as $sp5ef3b6)
        {
            for ($spd13009 = 0, $sp0b39eb = '';$spd13009 < strlen($sp5ef3b6) && isset($sp5ef3b6[$spd13009 + 1]);$spd13009 += 2)
            {
                $sp7e80fd = base_convert($sp5ef3b6[$spd13009], 36, 10) - ($spd13009 / 2 + $sp11736a) % 27;
                $sp394a62 = base_convert($sp5ef3b6[$spd13009 + 1], 36, 10) - ($spd13009 / 2 + $sp11736a) % 24;
                $sp0b39eb .= $sp394a62 * pow($sp7e80fd, $spffa141 - $sp60e693 - 5) % $spffa141;
            }
            $sp0b39eb = base_convert($sp0b39eb, 10, 16);
            $sp11736a += $sp60e693;
            for ($sp7e80fd = 0;$sp7e80fd < strlen($sp0b39eb);$sp7e80fd += 2)
            {
                $sp74fa89 .= @chr(hexdec($sp0b39eb[$sp7e80fd] . $sp0b39eb[$sp7e80fd + 1]));
            }
        }
        $spe7c719 = new \stdClass();
        @(list($spe7c719->domains, $spe7c719->expiration, $spe7c719->comment, $sp462573) = explode('#', $sp74fa89, 4));
        $spe7c719->domains = explode(',', $spe7c719->domains);
        if (!empty($sp462573))
        {
            $spdc6554 = self::sp54014b(1);
            $sp38324f = self::sp54014b(2);
            $sp636814 = self::sp54014b(3);
            $sp462573 = (new $spdc6554())->{$sp38324f}($sp636814($sp462573));
            list($spe7c719->nl['domains'], $spe7c719->nl['version_type']) = explode('#', $sp462573, 2);
            if (!empty($spe7c719->nl['domains']))
            {
                $sp337e74 = array();
                foreach (explode(',', $spe7c719->nl['domains']) as $sp28ac10)
                {
                    $sp337e74[] = trim(htmlspecialchars(strip_tags($sp28ac10)));
                }
                $spe7c719->nl['domains'] = $sp337e74;
            }
        }
        else
        {
            $spe7c719->nl['domains'] = array();
            $spe7c719->nl['version_type'] = 'lite';
        }
        return $spe7c719;
    }
    public function setResponseType($spd5cd98)
    {
        $this->responseType = $spd5cd98;
    }
    public function __destruct()
    {
        if ($this->responseType == RESPONSE_HTML && self::$validLicense === false && strpos($_SERVER['REQUEST_URI'], 'backend') === false)
        {
            print self::sp54014b(0);
        }
    }
    private static $freeModules = array(
        'LigPay',
        'Rozetka'
    );
    private function sp9f43f8()
    {
        if (self::$inited === false)
        {
            self::$validLicense = false;
            $sp7c1a60 = ServiceLocator::getInstance();
            self::$config = $sp7c1a60->getService(Config::class);
            self::$module = $sp7c1a60->getService(Module::class);
            self::$smarty = $sp7c1a60->getService(Smarty::class);
            self::$response = $sp7c1a60->getService(Response::class);
            self::$request = $sp7c1a60->getService(Request::class);
            $sp04b187 = $this->spfd1692(self::$config->license);
            if (self::spb0a7c0() && $this->sp3ba4d0())
            {
                $this->spf64008($sp04b187->nl['domains']);
            }
            self::$response->addHeader(self::sp54014b(6) . ' ' . self::$config->version . ' ' . $sp04b187->nl['version_type']);
            self::$inited = true;
        }
    }
    private function sp3ba4d0()
    {
        self::$validLicense = false;
        $spb5d9fc = $this->getLicenseExpiration();
        if ($spb5d9fc == '*' || strtotime($spb5d9fc) >= strtotime(date('d.m.Y')))
        {
            self::$validLicense = true;
        }
        return self::$validLicense;
    }
    private static function sp54014b($spfc800c)
    {
        $sp997ed0 = '';
        if (isset(self::$codes[$spfc800c]))
        {
            foreach (self::$codes[$spfc800c] as $sp54014b)
            {
                $sp997ed0 .= chr($sp54014b);
            }
        }
        return $sp997ed0;
    }
}
