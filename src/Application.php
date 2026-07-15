<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.3.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App;

// Fail-fail Authentication yang kita panggil masuk
use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceInterface;
use Authentication\AuthenticationServiceProviderInterface;
use Authentication\Middleware\AuthenticationMiddleware;
use Psr\Http\Message\ServerRequestInterface;

use App\Middleware\HostHeaderMiddleware;
use Cake\Core\Configure;
use Cake\Core\ContainerInterface;
use Cake\Datasource\FactoryLocator;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Event\EventManagerInterface;
use Cake\Http\BaseApplication;
use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\ORM\Locator\TableLocator;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;
use Cake\Routing\Router; // 👈 Ditambah untuk menyelesaikan isu URL localhost/eletter/ dinamik

/**
 * Application setup class.
 *
 * Di sini kita tambah "implements AuthenticationServiceProviderInterface" supaya CakePHP tahu app ini ada sistem login
 */
class Application extends BaseApplication implements AuthenticationServiceProviderInterface
{
    /**
     * Load all the application configuration and bootstrap logic.
     *
     * @return void
     */
    public function bootstrap(): void
    {
        // Call parent to load bootstrap from files.
        parent::bootstrap();

        $this->addPlugin('Authentication');

        // By default, does not allow fallback classes.
        FactoryLocator::add('Table', (new TableLocator())->allowFallbackClass(false));
    }

    /**
     * Setup the middleware queue your application will use.
     *
     * @param \Cake\Http\MiddlewareQueue $middlewareQueue The middleware queue to setup.
     * @return \Cake\Http\MiddlewareQueue The updated middleware queue.
     */
    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        $middlewareQueue
            // 1. Tangkap kalau ada system error
            ->add(new ErrorHandlerMiddleware(Configure::read('Error'), $this))

            // 2. Jaga keselamatan Host Header
            ->add(new HostHeaderMiddleware())

            // 3. Menguruskan asset gambar/CSS/JS template
            ->add(new AssetMiddleware([
                'cacheTime' => Configure::read('Asset.cacheTime'),
            ]))

            // 4. Menguruskan hala tuju URL (Routing)
            ->add(new RoutingMiddleware($this))

            // 5. MEMASUKKAN SECURITY LOGIN (Kita tambah AuthenticationMiddleware di sini!)
            ->add(new AuthenticationMiddleware($this))

            // 6. Membaca data yang di-submit dari borang/form HTML
            ->add(new BodyParserMiddleware())

            // 7. Menghalang serangan hacker (CSRF Protection)
            ->add(new CsrfProtectionMiddleware([
                'httponly' => true,
            ]));

        return $middlewareQueue;
    }

    /**
     * Register application container services.
     */
    public function services(ContainerInterface $container): void
    {
    }

    /**
     * Register custom event listeners here
     */
    public function events(EventManagerInterface $eventManager): EventManagerInterface
    {
        return $eventManager;
    }

    /**
     * 🔐 FUNGSI KEMAS KINI: Memperbaiki URL Redirect Dinamik & Teks Biasa
     * Ditweak untuk menerima kata laluan teks biasa (Simple Text) tanpa Hash untuk testing.
     */
    public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface
    {
        // Menggunakan Router::url supaya CakePHP automatik tahu path /eletter/
        $loginUrl = Router::url(['controller' => 'Users', 'action' => 'login']);

        $authenticationService = new AuthenticationService([
            'unauthenticatedRedirect' => $loginUrl, // Memastikan jika ditendang keluar, dia pergi ke URL eletter yang betul
            'queryParam' => 'redirect',
        ]);

        // 1. Tetapkan tiada pengasidan (None) pada bahagian semakan Identifier pangkalan data
        $authenticationService->loadIdentifier('Authentication.Password', [
            'fields' => [
                'username' => 'matrix_id',
                'password' => 'password',
            ],
            'passwordHasher' => 'Authentication.None', // 👈 Paksa terima teks biasa '123'
        ]);

        // Aktifkan pengepaman Session & Form Login
        $authenticationService->loadAuthenticator('Authentication.Session');
        
        // 2. Tetapkan tiada pengasidan (None) pada bahagian pemprosesan Form data
        $authenticationService->loadAuthenticator('Authentication.Form', [
            'fields' => [
                'username' => 'matrix_id',
                'password' => 'password',
            ],
            'loginUrl' => $loginUrl,
            'passwordHasher' => 'Authentication.None', // 👈 Paksa terima teks biasa '123'
        ]);

        return $authenticationService;
    }
}