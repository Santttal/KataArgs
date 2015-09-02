<?php

namespace KataArgs\Test;

use KataArgs\FlagParser;

class FlagParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FlagParser
     */
    private $parser;

    protected function setUp()
    {
        $this->parser = new FlagParser();
    }

    /**
     * @test
     */
    public function parse_GivenEmptyString_ReturnsEmptyArray()
    {
        $flags = $this->parser->parse('');

        assertThat($flags, is(emptyArray()));
    }

    /**
     * @test
     */
    public function parse_GivenStringWithOneFlag_ReturnsArrayWithOneFlag()
    {
        $flags = $this->parser->parse('-f');

        assertThat($flags[0]->getName(), is(equalTo('f')));
    }

    /**
     * @test
     */
    public function parse_GivenStringWithTwoFlags_ReturnsArrayWithTwoFlags()
    {
        $flags = $this->parser->parse('-a -b');

        assertThat($flags, is(arrayWithSize(2)));
    }

    /**
     * @test
     */
    public function parse_GivenStringWithFlagAndParam_CreatesFlagObjectWithThatParam()
    {
        $flags = $this->parser->parse('-f uck');

        assertThat($flags[0]->getValues(), is(equalTo(['uck'])));
    }

    /**
     * @test
     */
    public function parse_GivenStringWithFlagAndParamSeparatedByComma_CreatesFlagObjectWithArrayParam()
    {
        $flags = $this->parser->parse('-a b,c,d');

        assertThat($flags[0]->getValues(), arrayContainingInAnyOrder('b', 'd', 'c'));
    }

    /**
     * @test
     */
    public function parse_youtube()
    {
        $flags = $this->parser->parse('-u https://www.youtube.com/watch?v=jIVfMCMM5lY');

        assertThat($flags[0]->getValues()[0], is(equalTo('https://www.youtube.com/watch?v=jIVfMCMM5lY')));
    }
}
