<?php

namespace App\Service;

use App\Model\Formatter;
use SimpleXMLElement;

final class XmlService implements Formatter
{
    /**
     * @throws \Exception
     */
    public function responseFormatting(array $teams): \SimpleXMLElement
    {
        return $this->arrayToXml($teams);
    }

    /**
     * @throws \Exception
     */
    private function arrayToXml($array, $rootElement = null, $xml = null)
    {
        $_xml = $xml;

        if ($_xml === null) {
            $_xml = new SimpleXMLElement($rootElement ?? '<root/>');
        }

        foreach ($array as $key => $value) {

            if (is_array($value)) {
                if(is_int($key)){
                    $key = "e";
                }

                $this->arrayToXml($value, $key, $_xml->addChild($key));
            } else {
                $_xml->addChild($key, $value);
            }
        }

        return $_xml;
    }
}