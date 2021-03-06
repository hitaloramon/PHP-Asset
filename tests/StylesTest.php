<?php
/**
 * PHP library for handling styles and scripts: Add, minify, unify and print.
 *
 * @author    Josantonius <hello@josantonius.com>
 * @copyright 2016 - 2018 (c) Josantonius - PHP-Assets
 * @license   https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link      https://github.com/Josantonius/PHP-Asset
 * @since     1.1.5
 */
namespace Josantonius\Asset;

use PHPUnit\Framework\TestCase;

/**
 * Tests class for Asset library.
 *
 * @since 1.1.5
 */
final class StylesTest extends TestCase
{
    /**
     * Asset instance.
     *
     * @since 1.1.6
     *
     * @var object
     */
    protected $Asset;

    /**
     * Assets url.
     *
     * @var string
     */
    protected $assetsUrl;

    /**
     * Set up.
     */
    public function setUp()
    {
        parent::setUp();

        $this->Asset = new Asset;

        $url = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

        $this->assetsUrl = 'https://' . $url;
    }

    /**
     * Check if it is an instance of Asset.
     *
     * @since 1.1.6
     */
    public function testIsInstanceOf()
    {
        $this->assertInstanceOf('\Josantonius\Asset\Asset', $this->Asset);
    }

    /**
     * Add style.
     */
    public function testAddStyle()
    {
        $asset = $this->Asset;

        $this->assertTrue(
            $asset::add('style', [
                'name' => 'style-first',
                'url' => $this->assetsUrl . 'css/style.css',
            ])
        );
    }

    /**
     * Add style with version.
     */
    public function testAddStyleWithVersion()
    {
        $asset = $this->Asset;

        $this->assertTrue(
            $asset::add('style', [
                'name' => 'style-second',
                'url' => $this->assetsUrl . 'css/style.css',
                'version' => '1.0.0'
            ])
        );
    }

    /**
     * Add style by adding all options.
     */
    public function testAddStyleAddingAllParams()
    {
        $asset = $this->Asset;

        $this->assertTrue(
            $asset::add('style', [
                'name' => 'style-third',
                'url' => $this->assetsUrl . 'css/custom.css',
                'version' => '1.1.3'
            ])
        );
    }

    /**
     * Add style without specifying a name. [FALSE|ERROR]
     */
    public function testAddStyleWithoutName()
    {
        $asset = $this->Asset;

        $this->assertFalse(
            $asset::add('style', [
                'url' => $this->assetsUrl . 'css/unknown.css',
                'attr' => 'defer',
            ])
        );
    }

    /**
     * Add style without specifying a url. [FALSE|ERROR]
     */
    public function testAddStyleWithoutUrl()
    {
        $asset = $this->Asset;

        $this->assertFalse(
            $asset::add('style', [
                'name' => 'unknown',
                'attr' => 'defer',
            ])
        );
    }

    /**
     * Check if the styles have been added correctly.
     */
    public function testIfStylesAddedCorrectly()
    {
        $asset = $this->Asset;

        $this->assertTrue(
            $asset::isAdded('style', 'style-first')
        );

        $this->assertTrue(
            $asset::isAdded('style', 'style-second')
        );

        $this->assertTrue(
            $asset::isAdded('style', 'style-third')
        );
    }

    /**
     * Delete added styles.
     */
    public function testRemoveAddedStyles()
    {
        $asset = $this->Asset;

        $this->assertTrue(
            $asset::remove('style', 'style-first')
        );
    }

    /**
     * Validation after deletion.
     */
    public function testValidationAfterDeletion()
    {
        $asset = $this->Asset;

        $this->assertFalse(
            $asset::isAdded('style', 'style-first')
        );
    }

    /**
     * Output styles.
     */
    public function testOutputStyles()
    {
        $asset = $this->Asset;

        $styles = $asset::outputStyles();

        $this->assertContains(
            "<link rel='stylesheet' href='https://jst.com/css/custom.css'>",
            $styles
        );

        $this->assertContains(
            "<link rel='stylesheet' href='https://jst.com/css/style.css'>",
            $styles
        );
    }

    /**
     * Output when there are not header styles loaded.
     */
    public function testOutputWhenNotStylesLoaded()
    {
        $asset = $this->Asset;

        $this->assertFalse(
            $asset::outputStyles()
        );
    }
}
