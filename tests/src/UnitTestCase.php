<?php

declare(strict_types=1);

namespace ItalyStrap\Tests;

use Codeception\Test\Unit;
use ItalyStrap\Asset\Infrastructure\InlineStyleGenerator;
use ItalyStrap\Components\AuthorInfo;
use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Customizer\FieldControlFactory;
use ItalyStrap\Empress\AurynConfigInterface;
use ItalyStrap\Empress\Injector;
use ItalyStrap\Event\EventDispatcherInterface;
use ItalyStrap\Event\ListenerRegisterInterface;
use ItalyStrap\Event\SubscriberRegisterInterface;
use ItalyStrap\Finder\FileInfoFactoryInterface;
use ItalyStrap\Finder\FinderInterface;
use ItalyStrap\HTML\Tag;
use ItalyStrap\Navigation\UI\Components\Navbar;
use ItalyStrap\View\ViewInterface;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophet;
use ItalyStrap\Theme\Infrastructure\Support as ThemeSupport;
use UnitTester;
use WP_Customize_Manager;
use WP_Theme;

class UnitTestCase extends Unit
{
    use UndefinedFunctionDefinitionTrait;

    protected UnitTester $tester;

    protected Prophet $prophet;

    protected ObjectProphecy $config;

    protected function getConfig(): ConfigInterface
    {
        return $this->config->reveal();
    }

    protected ObjectProphecy $globalDispatcher;

    protected function makeGlobalDispatcher(): EventDispatcherInterface
    {
        return $this->globalDispatcher->reveal();
    }

    protected ObjectProphecy $dispatcher;

    protected function makeDispatcher(): \Psr\EventDispatcher\EventDispatcherInterface
    {
        return $this->dispatcher->reveal();
    }

    protected ObjectProphecy $subscriberRegister;

    protected function getSubscriberRegister(): SubscriberRegisterInterface
    {
        return $this->subscriberRegister->reveal();
    }

    protected ObjectProphecy $view;

    protected function getView(): ViewInterface
    {
        return $this->view->reveal();
    }

    protected ObjectProphecy $injector;

    protected function getInjector(): Injector
    {
        return $this->injector->reveal();
    }

    protected ObjectProphecy $aurynConfigInterface;

    protected function getAurynConfigInterface(): AurynConfigInterface
    {
        return $this->aurynConfigInterface->reveal();
    }

    protected ObjectProphecy $finder;

    protected function getFinder(): FinderInterface
    {
        return $this->finder->reveal();
    }

    protected ObjectProphecy $theme_support;

    protected function getThemeSupport(): ThemeSupport
    {
        return $this->theme_support->reveal();
    }

    protected ObjectProphecy $component;

    protected function getComponent(): ComponentInterface
    {
        return $this->component->reveal();
    }

    protected ObjectProphecy $navbar;

    protected function getNavbar(): Navbar
    {
        return $this->navbar->reveal();
    }

    protected ObjectProphecy $tag;

    protected function getTag(): Tag
    {
        return $this->tag->reveal();
    }

    protected ObjectProphecy $fileInfoFactory;

    protected function getFileInfoFactory(): FileInfoFactoryInterface
    {
        return $this->fileInfoFactory->reveal();
    }

    protected ObjectProphecy $inlineStyleGenerator;

    protected function getInlineStyleGenerator(): InlineStyleGenerator
    {
        return $this->inlineStyleGenerator->reveal();
    }

    protected ObjectProphecy $theme;

    protected function getTheme(): WP_Theme
    {
        return $this->theme->reveal();
    }

    protected ObjectProphecy $manager;

    protected function getWPCustomizeManager(): WP_Customize_Manager
    {
        return $this->manager->reveal();
    }

    protected ObjectProphecy $control;

    protected function getFieldControlFactory(): FieldControlFactory
    {
        return $this->control->reveal();
    }

    protected ObjectProphecy $author;

    protected function getAuthorInfo(): AuthorInfo
    {
        return $this->author->reveal();
    }

    protected ObjectProphecy $listenerRegister;

    protected function getListenerRegister(): ListenerRegisterInterface
    {
        return $this->listenerRegister->reveal();
    }

    // phpcs:ignore
    protected function _before()
    {
        $this->setUpProphet();
    }

    // phpcs:ignore
    protected function _after()
    {
        $this->tearDownProphet();
    }

    private function setUpProphet()
    {
        $this->prophet = new Prophet();
        $this->config = $this->prophet->prophesize(ConfigInterface::class);
        $this->view = $this->prophet->prophesize(ViewInterface::class);
        $this->globalDispatcher = $this->prophet->prophesize(EventDispatcherInterface::class);
        $this->dispatcher = $this->prophet->prophesize(\Psr\EventDispatcher\EventDispatcherInterface::class);
        $this->subscriberRegister = $this->prophet->prophesize(SubscriberRegisterInterface::class);
        $this->injector = $this->prophet->prophesize(Injector::class);
        $this->aurynConfigInterface = $this->prophet->prophesize(AurynConfigInterface::class);
        $this->finder = $this->prophet->prophesize(FinderInterface::class);
        $this->theme_support = $this->prophet->prophesize(ThemeSupport::class);
        $this->component = $this->prophet->prophesize(ComponentInterface::class);
        $this->navbar = $this->prophet->prophesize(Navbar::class);
        $this->tag = $this->prophet->prophesize(Tag::class);
        $this->fileInfoFactory = $this->prophet->prophesize(FileInfoFactoryInterface::class);
        $this->inlineStyleGenerator = $this->prophet->prophesize(InlineStyleGenerator::class);
        $this->theme = $this->prophet->prophesize(WP_Theme::class);
        $this->manager = $this->prophet->prophesize(WP_Customize_Manager::class);
        $this->control = $this->prophet->prophesize(FieldControlFactory::class);
        $this->author = $this->prophet->prophesize(AuthorInfo::class);
        $this->listenerRegister = $this->prophet->prophesize(ListenerRegisterInterface::class);
//      \Brain\Monkey\setUp();
    }

    private function tearDownProphet()
    {
//      \Brain\Monkey\tearDown();
        $this->prophet->checkPredictions();
    }

//    public function testItShouldBeInstantiable()
//    {
//        $sut = $this->makeInstance();
//    }
}
