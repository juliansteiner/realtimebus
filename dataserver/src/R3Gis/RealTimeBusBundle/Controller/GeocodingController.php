<?php
/*
Real Time Bus
VDV Import

Copyright (C) 2013 TIS Innovation Park - Bolzano/Bozen - Italy

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Affero General Public License as
published by the Free Software Foundation, either version 3 of the
License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.
*/

namespace R3Gis\RealTimeBusBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use R3Gis\RealTimeBusBundle\Model\Geocoding\Geocoder;
use R3Gis\RealTimeBusBundle\Model\RealTimeBus\LinesUtils;

/**
 * @author Francesco D'Alesio <francesco.dalesio@r3-gis.com>
 */
class GeocodingController extends Controller {

    /**
     * @Route("/geocode")
     * @Method({"GET"})
     */
    public function geocodeAction(Request $request) {
        $callbackFunction = $request->query->get('jsonp');
        $linesStr = $request->query->get('lines');
        
        $geocode = new Geocoder($this->get('doctrine')->getConnection());
        
        if($linesStr) {
            $geocode->setLines(LinesUtils::getLinesFromQuery($linesStr));
        }
        
        $results = $geocode->find($request);
        
        return ControllerUtils::jResponse($results, $callbackFunction);
    }
}
