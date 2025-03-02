<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | The default title of your admin panel, this goes into the title tag
    | of your page. You can override it per page with the title section.
    | You can optionally also specify a title prefix and/or postfix.
    |
    */

    'title' => 'Esteira Comex',

    'title_prefix' => '',

    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | This logo is displayed at the upper left corner of your admin panel.
    | You can use basic HTML here if you want. The logo has also a mini
    | variant, used for the mini side bar. Make it 3 letters or so
    |
    */

    'logo' => '<p class="sombra-estilosa"><img src="/images/logo-caixa.png" height="25px" width="30px" alt="X" class="sombra-estilosa">     Esteira.Comex</p>',

    'logo_mini' => '<img src="/images/logo-caixa.png" height="50%" width="50%" alt="X">',

    /*
    |--------------------------------------------------------------------------
    | Skin Color
    |--------------------------------------------------------------------------
    |
    | Choose a skin color for your admin panel. The available skin colors:
    | blue, black, purple, yellow, red, and green. Each skin also has a
    | ligth variant: blue-light, purple-light, purple-light, etc.
    |
    */

    'skin' => 'blue',

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Choose a layout for your admin panel. The available layout options:
    | null, 'boxed', 'fixed', 'top-nav'. null is the default, top-nav
    | removes the sidebar and places your menu in the top navbar
    |
    */

    'layout' => null,

    /*
    |--------------------------------------------------------------------------
    | Collapse Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we choose and option to be able to start with a collapsed side
    | bar. To adjust your sidebar layout simply set this  either true
    | this is compatible with layouts except top-nav layout option
    |
    */

    'collapse_sidebar' => false,

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Register here your dashboard, logout, login and register URLs. The
    | logout URL automatically sends a POST request in Laravel 5.3 or higher.
    | You can set the request to a GET or POST with logout_method.
    | Set register_url to null if you don't want a register link.
    |
    */

    'dashboard_url' => 'esteiracomex',

    'logout_url' => 'logout',

    'logout_method' => null,

    'login_url' => 'login',

    'register_url' => 'register',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Specify your menu items to display in the left sidebar. Each menu item
    | should have a text and and a URL. You can also specify an icon from
    | Font Awesome. A string instead of an array represents a header in sidebar
    | layout. The 'can' is a filter on Laravel's built in Gate functionality.
    |
    */

    'menu' => [
        'MENU INICIAL', [
            'text'        => 'Introdução',
            'url'         => 'esteiracomex/',
            'icon'        => 'home',
            'perfil'      => ['AGENCIA', 'SR', 'AUDITOR', 'MATRIZ', 'MIDDLE', 'GESTOR', env('NOME_NOSSA_UNIDADE'), 'GECAM', 'GELIT', 'CELIT', 'CEOPC'],
        ],
        'SOLICITAÇÕES E ACOMPANHAMENTOS', [
            'text'    => 'Solicitar Atendimento',
            'icon'    => 'sign-in',
            'perfil'      => ['AGENCIA', 'SR', 'AUDITOR', 'MATRIZ', 'MIDDLE', 'GESTOR', env('NOME_NOSSA_UNIDADE'), 'GECAM', 'GELIT', 'CELIT', 'CEOPC'],
            'submenu' => [
                [
                    'text'       => 'Atualizar e-mail cliente',
                    'url'        => 'http://www.ceopc.sp.caixa/esteiracomex2/cadastro_email_cliente_comex.php',
                    'icon'       => 'at',
                    'icon_color' => 'yellow',
                    'perfil'      => ['AGENCIA', 'SR', 'AUDITOR', 'MATRIZ', 'MIDDLE', 'GESTOR', env('NOME_NOSSA_UNIDADE'), 'GECAM', 'GELIT', 'CELIT', 'CEOPC'],
                ],
                [
                    'text'   => 'Conformidade Antecipados',
                    'url'    => 'http://www.geopc.mz.caixa/esteiracomex/lista_contratos.php',
                    'icon'   => 'forward',
                    'perfil'      => ['AGENCIA', 'SR', 'AUDITOR', 'MATRIZ', 'MIDDLE', 'GESTOR', env('NOME_NOSSA_UNIDADE'), 'GECAM', 'GELIT', 'CELIT', 'CEOPC'],
                ],
                [
                    'text'       => 'Cadastrar Contratação',
                    'url'        => 'esteiracomex/solicitar/contratacao',
                    'icon'       => 'wpforms',
                    'icon_color' => 'yellow',
                    'perfil'      => ['AGENCIA', 'SR', 'AUDITOR', 'MATRIZ', 'MIDDLE', 'GESTOR', env('NOME_NOSSA_UNIDADE'), 'GECAM', 'GELIT', 'CELIT', 'CEOPC'],
                ],
                [
                    'text'   => 'Liquidação ACC/ACE',
                    'url'    => 'http://www.geopc.mz.caixa/esteiracomex/lista_acc.php',
                    'icon'   => 'ship',
                    'perfil'      => ['AGENCIA', 'SR', 'AUDITOR', 'MATRIZ', 'MIDDLE', 'GESTOR', env('NOME_NOSSA_UNIDADE'), 'GECAM', 'GELIT', 'CELIT', 'CEOPC'],
                ],
            ],
        ],
        [
            'text'    => 'Acompanhamentos',
            'icon'    => 'files-o',
            'perfil'      => ['AGENCIA', 'SR', 'AUDITOR', 'MATRIZ', 'MIDDLE', 'GESTOR', env('NOME_NOSSA_UNIDADE'), 'GECAM', 'GELIT', 'CELIT', 'CEOPC'],
            'submenu' =>  [
                [
                    'text'       => 'Minhas Demandas',
                    'icon'       => 'envelope',
                    'url'        => 'esteiracomex/acompanhar/minhas-demandas',
                    'icon_color' => 'yellow',
                    'perfil'      => ['AGENCIA', 'SR', 'AUDITOR', 'MATRIZ', 'MIDDLE', 'GESTOR', env('NOME_NOSSA_UNIDADE'), 'GECAM', 'GELIT', 'CELIT', 'CEOPC'],
                ],
                [
                    'text'   => 'ACC/ACE',
                    'url'    => 'http://www.geopc.mz.caixa/esteiracomex/acompanha_acc.php',
                    'icon'   => 'ship',
                    'perfil'      => ['AGENCIA', 'SR', 'AUDITOR', 'MATRIZ', 'MIDDLE', 'GESTOR', env('NOME_NOSSA_UNIDADE'), 'GECAM', 'GELIT', 'CELIT', 'CEOPC'],
                ],
                [
                    'text'   => 'ACC/ACE - Liquidadas',
                    'url'    => 'http://www.geopc.mz.caixa/esteiracomex/finalizadas.php',
                    'icon'   => 'ship',
                    'perfil'      => ['AGENCIA', 'SR', 'AUDITOR', 'MATRIZ', 'MIDDLE', 'GESTOR', env('NOME_NOSSA_UNIDADE'), 'GECAM', 'GELIT', 'CELIT', 'CEOPC'],
                ],
                [
                    'text'       => 'Contratação - Pronto',
                    'url'        => 'esteiracomex/acompanhar/contratacao',
                    'icon'       => 'handshake-o',
                    'icon_color' => 'yellow',
                    'perfil'      => ['AGENCIA', 'SR', 'AUDITOR', 'MATRIZ', 'MIDDLE', 'GESTOR', env('NOME_NOSSA_UNIDADE'), 'GECAM', 'GELIT', 'CELIT', 'CEOPC'],
                ],
                [
                    'text'       => 'Contratação - Formalizados',
                    'icon'       => 'file',
                    'url'        => 'esteiracomex/acompanhar/formalizadas',
                    'icon_color' => 'yellow',
                    'perfil'      => ['AGENCIA', 'SR', 'AUDITOR', 'MATRIZ', 'MIDDLE', 'GESTOR', env('NOME_NOSSA_UNIDADE'), 'GECAM', 'GELIT', 'CELIT', 'CEOPC'],
                ],
                [
                    'text'       => 'CELIT - Autorização',
                    'icon'       => 'file',
                    'url'        => 'esteiracomex/acompanhar/liquidar',
                    'icon_color' => 'yellow',
                    'perfil'      => ['AGENCIA', 'SR', 'AUDITOR', 'MATRIZ', 'MIDDLE', 'GESTOR', env('NOME_NOSSA_UNIDADE'), 'GECAM', 'GELIT', 'CELIT', 'CEOPC'],
                ],
                [
                    'text'   => 'Operações Antecipadas',
                    'url'    => 'http://www.geopc.mz.caixa/esteiracomex/acompanha_conformidade.php',
                    'icon'   => 'fast-forward',
                    'perfil'      => ['AGENCIA', 'SR', 'AUDITOR', 'MATRIZ', 'MIDDLE', 'GESTOR', env('NOME_NOSSA_UNIDADE'), 'GECAM', 'GELIT', 'CELIT', 'CEOPC'],
                ],
                [
                    'text'   => 'Ordens de Pagamento',
                    'url'    => 'http://www.geopc.mz.caixa/esteiracomex/opes_enviadas.php',
                    'icon'   => 'money',
                    'perfil'      => ['AGENCIA', 'SR', 'AUDITOR', 'MATRIZ', 'MIDDLE', 'GESTOR', env('NOME_NOSSA_UNIDADE'), 'GECAM', 'GELIT', 'CELIT', 'CEOPC'],
                ],
                [
                    'text'   => 'Middle Office',
                    'url'    => 'http://www.geopc.mz.caixa/esteiracomex/middleoffice.php',
                    'icon'   => 'copy',
                    'perfil'      => ['MIDDLE'],
                ],
                [
                    'text'   => 'GECAM',
                    'url'    => 'http://www.geopc.mz.caixa/esteiracomex/gerencial_gecam.php',
                    'icon'   => 'gavel',
                    'perfil'      => ['AGENCIA', 'SR', 'AUDITOR', 'MATRIZ', 'MIDDLE', 'GESTOR', env('NOME_NOSSA_UNIDADE'), 'GECAM', 'GELIT', 'CELIT', 'CEOPC'],
                ],
            ],
        ],
        'GERENCIAL', [
            'text'        => 'Distribuição',
            'url'         => 'esteiracomex/gerenciar/distribuir',
            'icon'        => 'share-square',
            'icon_color'  => 'yellow',
            'perfil'      => ['GESTOR', env('NOME_NOSSA_UNIDADE'), 'CEOPC'],
        ],
        // [
        //     'text'        => 'Níveis de Acesso',
        //     'url'         => 'esteiracomex/gerenciar/niveis-acesso',
        //     'icon'        => 'lock',
        //     'icon_color'  => 'yellow',
        //     'perfil'      => ['GESTOR', env('NOME_NOSSA_UNIDADE'), 'CEOPC'],
        // ],
        [
            'text'    => 'Indicadores',
            'icon'    => 'bar-chart',
            'perfil'      => ['AGENCIA', 'SR', 'AUDITOR', 'MATRIZ', 'MIDDLE', 'GESTOR', env('NOME_NOSSA_UNIDADE'), 'GECAM', 'GELIT', 'CELIT', 'CEOPC'],
            'submenu' => [
                [    
                    'text'        => 'Antecipados',
                    'url'         => 'http://www.geopc.mz.caixa/esteiracomex/indicadores_pronto_impexp.php',
                    'icon'        => 'bar-chart',
                    'perfil'      => ['AGENCIA', 'SR', 'AUDITOR', 'MATRIZ', 'MIDDLE', 'GESTOR', env('NOME_NOSSA_UNIDADE'), 'GECAM', 'GELIT', 'CELIT', 'CEOPC'],
                ],
                [
                    'text'        => 'COMEX',
                    'url'         => 'http://www.geopc.mz.caixa/esteiracomex/indicadores.php',
                    'icon'        => 'bar-chart',
                    'icon_color'  => 'yellow',
                    'perfil'      => ['AGENCIA', 'SR', 'AUDITOR', 'MATRIZ', 'MIDDLE', 'GESTOR', env('NOME_NOSSA_UNIDADE'), 'GECAM', 'GELIT', 'CELIT', 'CEOPC'],
                ],
                [
                    'text'        => 'Conquiste',
                    'url'         => 'http://conquiste.caixa/2019/home.html',
                    'icon'        => 'bar-chart',
                    'perfil'      => ['AGENCIA', 'SR', 'AUDITOR', 'MATRIZ', 'MIDDLE', 'GESTOR', env('NOME_NOSSA_UNIDADE'), 'GECAM', 'GELIT', 'CELIT', 'CEOPC'],
                ],
            ]
        ],
        'WIKI / MANUAL ', [
            'text'        => 'Manual Esteira',
            'url'         => 'http://www.geopc.mz.caixa/esteiracomex/cartilha.pdf',
            'icon'        => 'book',
            'perfil'      => ['AGENCIA', 'SR', 'AUDITOR', 'MATRIZ', 'MIDDLE', 'GESTOR', env('NOME_NOSSA_UNIDADE'), 'GECAM', 'GELIT', 'CELIT', 'CEOPC'],
        ],
        [
            'text'        => 'Autorização E-mail Cliente',
            'url'         => 'http://www.geopc.mz.caixa/esteiracomex/ClienteAutorizaEnvioEmail.docx',
            'icon'        => 'download',
            'icon_color'  => 'yellow',
            'perfil'      => ['AGENCIA', 'SR', 'AUDITOR', 'MATRIZ', 'MIDDLE', 'GESTOR', env('NOME_NOSSA_UNIDADE'), 'GECAM', 'GELIT', 'CELIT', 'CEOPC'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Choose what filters you want to include for rendering the menu.
    | You can add your own filters to this array after you've created them.
    | You can comment out the GateFilter if you don't want to use Laravel's
    | built in Gate functionality
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Choose which JavaScript plugins should be included. At this moment,
    | only DataTables is supported as a plugin. Set the value to true
    | to include the JavaScript file from a CDN via a script tag.
    |
    */

    'plugins' => [
        'datatables' => true,
        'select2'    => true,
        'chartjs'    => true,
    ],
];
