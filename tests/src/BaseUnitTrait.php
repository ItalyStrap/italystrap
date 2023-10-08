<?php

declare(strict_types=1);

namespace ItalyStrap\Tests;

use ItalyStrap\Asset\Infrastructure\InlineStyleGenerator;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Customizer\FieldControlFactory;
use ItalyStrap\Empress\AurynConfigInterface;
use ItalyStrap\Empress\Injector;
use ItalyStrap\Event\EventDispatcherInterface;
use ItalyStrap\Event\SubscriberRegisterInterface;
use ItalyStrap\Finder\FileInfoFactoryInterface;
use ItalyStrap\Finder\FinderInterface;
use ItalyStrap\HTML\Tag;
use ItalyStrap\Navigation\UI\Components\Navbar;
use ItalyStrap\Theme\Infrastructure\Support as ThemeSupport;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Elements\AuthorInfo;
use ItalyStrap\View\ViewInterface;
use Prophecy\Prophet;

trait BaseUnitTrait
{
    /** @var \UnitTester  */
    protected $tester;

    private \Prophecy\Prophet $prophet;

    private \Prophecy\Prophecy\ObjectProphecy $config;

    public function getConfig(): ConfigInterface
    {
        return $this->config->reveal();
    }

    private \Prophecy\Prophecy\ObjectProphecy $dispatcher;

    public function getDispatcher(): EventDispatcherInterface
    {
        return $this->dispatcher->reveal();
    }

    private \Prophecy\Prophecy\ObjectProphecy $subscriberRegister;

    public function getSubscriberRegister(): SubscriberRegisterInterface
    {
        return $this->subscriberRegister->reveal();
    }

    private \Prophecy\Prophecy\ObjectProphecy $view;

    public function getView(): ViewInterface
    {
        return $this->view->reveal();
    }

    private \Prophecy\Prophecy\ObjectProphecy $injector;

    public function getInjector(): Injector
    {
        return $this->injector->reveal();
    }

    private \Prophecy\Prophecy\ObjectProphecy $aurynConfigInterface;

    public function getAurynConfigInterface(): AurynConfigInterface
    {
        return $this->aurynConfigInterface->reveal();
    }

    private \Prophecy\Prophecy\ObjectProphecy $finder;

    public function getFinder(): FinderInterface
    {
        return $this->finder->reveal();
    }

    private \Prophecy\Prophecy\ObjectProphecy $theme_support;

    public function getThemeSupport(): ThemeSupport
    {
        return $this->theme_support->reveal();
    }

    private \Prophecy\Prophecy\ObjectProphecy $component;

    public function getComponent(): ComponentInterface
    {
        return $this->component->reveal();
    }

    private \Prophecy\Prophecy\ObjectProphecy $navbar;

    public function getNavbar(): Navbar
    {
        return $this->navbar->reveal();
    }

    private \Prophecy\Prophecy\ObjectProphecy $tag;

    public function getTag(): Tag
    {
        return $this->tag->reveal();
    }

    private \Prophecy\Prophecy\ObjectProphecy $fileInfoFactory;

    public function getFileInfoFactory(): FileInfoFactoryInterface
    {
        return $this->fileInfoFactory->reveal();
    }

    private \Prophecy\Prophecy\ObjectProphecy $inlineStyleGenerator;

    public function getInlineStyleGenerator(): InlineStyleGenerator
    {
        return $this->inlineStyleGenerator->reveal();
    }

    private \Prophecy\Prophecy\ObjectProphecy $theme;

    public function getTheme(): \WP_Theme
    {
        return $this->theme->reveal();
    }

    private \Prophecy\Prophecy\ObjectProphecy $manager;

    public function getWPCustomizeManager(): \WP_Customize_Manager
    {
        return $this->manager->reveal();
    }

    private \Prophecy\Prophecy\ObjectProphecy $control;

    public function getFieldControlFactory(): FieldControlFactory
    {
        return $this->control->reveal();
    }

    private \Prophecy\Prophecy\ObjectProphecy $author;

    public function getAuthorInfo(): AuthorInfo
    {
        return $this->author->reveal();
    }

	// phpcs:ignore
	protected function _before() {
        $this->setUpProphet();
    }

	// phpcs:ignore
	protected function _after() {
        $this->tearDownProphet();
    }

    private function setUpProphet()
    {
        $this->prophet = new Prophet();
        $this->config = $this->prophet->prophesize(ConfigInterface::class);
        $this->view = $this->prophet->prophesize(ViewInterface::class);
        $this->dispatcher = $this->prophet->prophesize(EventDispatcherInterface::class);
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
        $this->theme = $this->prophet->prophesize(\WP_Theme::class);
        $this->manager = $this->prophet->prophesize(\WP_Customize_Manager::class);
        $this->control = $this->prophet->prophesize(FieldControlFactory::class);
        $this->author = $this->prophet->prophesize(AuthorInfo::class);
//      \Brain\Monkey\setUp();
    }

    private function tearDownProphet()
    {
//      \Brain\Monkey\tearDown();
        $this->prophet->checkPredictions();
    }

    abstract protected function getInstance();

    /**
     * @test
     */
    public function itShouldBeInstantiable()
    {
        $sut = $this->getInstance();
    }
}
