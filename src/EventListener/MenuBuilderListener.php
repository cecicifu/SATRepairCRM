<?php

namespace App\EventListener;

use Sonata\AdminBundle\Event\ConfigureMenuEvent;

final class MenuBuilderListener
{
    public function addMenuItems(ConfigureMenuEvent $event): void
    {
        $menu = $event->getMenu();

        $menu->addChild('dashboard', [
            'label' => 'Dashboard',
            'route' => 'sonata_admin_dashboard',
        ])->setExtras([
            'icon' => '<i class="fas fa-tachometer-alt"></i>',
        ]);

        $menu->addChild('logout', [
            'label' => 'Logout',
            'route' => 'app_logout',
        ])->setExtras([
            'icon' => '<i class="fas fa-sign-out-alt"></i>',
        ]);
    }
}