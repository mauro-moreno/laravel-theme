<?php

use MauroMoreno\LaravelTheme\Tests\TestCase\TestCaseWithDatabase;
use Orchestra\Testbench\TestCase;
use MauroMoreno\LaravelTheme\Theme;
use MauroMoreno\LaravelTheme\Themes;
use MauroMoreno\LaravelTheme\ThemeServiceProvider;

class ExampleTest extends TestCase
{
    // -----------------------------------------------
    //   add Service Providers & Facades
    // -----------------------------------------------
    protected function getPackageProviders($app)
    {
        return [
            MauroMoreno\LaravelTheme\ThemeServiceProvider::class,
        ];
    }


    protected function getPackageAliases($app)
    {
        return [
            'ThemeFacade' => MauroMoreno\LaravelTheme\Facades\Theme::class,
        ];
    }

    // -----------------------------------------------
    //  Tests
    // -----------------------------------------------
    public function testTheme()
    {
        $theme1 = new Theme('theme1');
        $this->assertInstanceOf(Theme::class, $theme1);

        $this->assertEquals('theme1', $theme1->name);
        $this->assertEquals('theme1', $theme1->assetPath);
        $this->assertEquals('theme1', $theme1->viewsPath);

        $theme2 = new Theme('theme2','asset','views');

        $this->assertEquals('theme2', $theme2->name);
        $this->assertEquals('asset',  $theme2->assetPath);
        $this->assertEquals('views',  $theme2->viewsPath);
    }

    public function testThemes()
    {
        $theme1 = new Theme('theme1');
        $theme2 = new Theme('theme2');

        $themes = new Themes();
        $themes->add($theme1);
        $themes->add($theme2,'theme1');

        $this->assertEquals($theme1, $themes->find('theme1'));
        $this->assertEquals($theme2, $themes->find('theme2'));
        $this->assertEquals(false, $themes->find('themeXXX'));

        $this->assertEquals($theme1, $theme2->getParent());

        $this->assertTrue($themes->exists('theme1'));
        $this->assertFalse($themes->exists('themeXXX'));

    }

   public function testFacade()
   {
        $this->assertInstanceOf(\MauroMoreno\LaravelTheme\Facades\Theme::class ,app()->make('ThemeFacade'));
        
        $theme1 = new Theme('theme1');
        ThemeFacade::add($theme1);

        $this->assertEquals($theme1, ThemeFacade::find('theme1'));
   } 
 

    public function testSetTheme()
    {
        $themes = new Themes();
        $theme1 = new Theme('theme1');
        $theme2 = new Theme('theme2');

        $themes->add($theme1);
        $themes->add($theme2);

        $themes->set('theme1');
        $this->assertEquals('theme1', $themes->get());
    }
}