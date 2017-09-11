<?php
// Routes
use Slim\Http\Request;
use Slim\Http\Response;
use App\Controllers\PublicController;
use App\Controllers\Admin\AuthController;
use App\Controllers\Admin\HomeController;
use App\Controllers\Admin\AdminRoleController;
use App\Controllers\Admin\AdminRouterController;
use App\Controllers\Admin\AdminMenuController;
use App\Controllers\Admin\AdminUserController;
use App\Middleware\VerifyAdminLoginMiddleware;
use App\Middleware\VerifyDomainMiddleware;
use App\Middleware\VerifyInstallMiddleware;

$adminDomain = env("ADMIN_DOMAIN", '');

//文件上传
$app->post('/public/upload', PublicController::class . ':upload');

$app->get('/admin', function (Request $req, Response $res) {
    return $res->withRedirect("/admin/home", 301);
});

$app->group("/admin", function () use ($app) {

    $app->get('/login', AuthController::class . ':login');

    $app->post('/login', AuthController::class . ':doLogin');

    $app->get('/logout', AuthController::class . ':logout');

    $app->group("", function () use ($app) {
        $app->get("/home", HomeController::class . ':home');

        //角色管理
        $app->get('/role', AdminRoleController::class . ':index')->setName("admin.role");
        $app->get('/role/data', AdminRoleController::class . ':data');
        $app->get('/role/delete', AdminRoleController::class . ':doDelete');
        $app->post('/role', AdminRoleController::class . ':save');

        //路由表管理
        $app->get('/router', AdminRouterController::class . ':index')->setName('admin.router');
        $app->get('/router/data', AdminRouterController::class . ':data');
        $app->get('/router/delete', AdminRouterController::class . ':doDelete');
        $app->post('/router', AdminRouterController::class . ':save');

        //菜单管理
        $app->get('/menu', AdminMenuController::class . ':index')->setName('admin.menu');
        $app->get('/menu/data', AdminMenuController::class . ":data");
        $app->get('/menu/delete', AdminMenuController::class . ':doDelete');
        $app->post('/menu', AdminMenuController::class . ':save');

        //用户管理
        $app->get('/user', AdminUserController::class . ':index')->setName('admin.user');
        $app->get('/user/data', AdminUserController::class . ':data');
        $app->get('/user/delete', AdminUserController::class . ':doDelete');
        $app->get('/user/switchLock', AdminUserController::class . ':doLock')
            ->add(new \App\Middleware\PermissionMiddleware("deny", "nb"));
        $app->post('/user', AdminUserController::class . ':save');


    })->add(VerifyAdminLoginMiddleware::class)->add(\App\Middleware\VerifyRouterMiddleware::class);

})->add(new VerifyInstallMiddleware(VerifyInstallMiddleware::INSTALL))
    ->add(new VerifyDomainMiddleware($adminDomain));

require __DIR__ . '/Routers/install.php';