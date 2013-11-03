<?php
require_once dirname(__FILE__) . '/../Converter.php';

class ConverterTest extends PHPUnit_Framework_TestCase
{
    public function testDefaultToHtml()
    {
        $converter = new Converter();

        // lists
        $html = $converter->defaultToHtml(" - 1\n - 2");
        $this->assertEquals($html, "<ul>\n<li>1</li>\n<li>2</li>\n</ul>\n");

        // one paragraph
        $html = $converter->defaultToHtml('test');
        $this->assertEquals($html, "<p>test</p>\n");

        // two paragraphs
        $html = $converter->defaultToHtml("test\n\nline2");
        $this->assertEquals($html, "<p>test</p>\n\n<p>line2</p>\n");
    }

    public function testHeaderToHtml()
    {
        $converter = new Converter();

        $html = $converter->headerToHtml('Heading');
        $this->assertEquals($html, "<h2>Heading</h2>\n");
    }

    public function testQuoteToHtml()
    {
        $converter = new Converter();

        // with cite
        $html = $converter->quoteToHtml('Text', 'Cite');
        $this->assertEquals(
            $html,
            "<blockquote><p>Text</p>\n<cite><p>Cite</p>\n</cite></blockquote>"
        );

        // without cite
        $html = $converter->quoteToHtml('Text');
        $this->assertEquals($html, "<blockquote><p>Text</p>\n</blockquote>");

        // with empty cite
        $html = $converter->quoteToHtml('Text', '');
        $this->assertEquals($html, "<blockquote><p>Text</p>\n</blockquote>");
    }

    public function testToHtml()
    {
        $converter = new Converter();

        // let's try a basic json
        $json = 
'{"data": [{
  "type": "quote",
  "data": { "text": "Text", "cite": "Cite" }
}]}';
        $html = $converter->toHtml($json);
        $this->assertEquals(
            $html,
            "<blockquote><p>Text</p>\n<cite><p>Cite</p>\n</cite></blockquote>"
        );

        // Lets convert a normal text type that uses the default converter
        $json = 
'{"data": [{
  "type": "text",
  "data": { "text": "test" }
}]}';
        $html = $converter->toHtml($json);
        $this->assertEquals($html, "<p>test</p>\n");
    }
}