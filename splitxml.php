<?php
header('Content-Type: text/html; charset=utf-8');
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$arrLocales = array('pl_PL', 'pl','Polish_Poland.28592');
setlocale( LC_ALL, $arrLocales );
date_default_timezone_set('Europe/Warsaw');
set_time_limit(0);
ini_set('memory_limit', '-1');
/**
* Function to break an xml file into several smaller files
* If the orig xml file is smaller than max size then it will be converted into a single file
* @param string $boundaryTag for product boundary tag name
* @param int $startAt file number to start at
* @param int maxItems how many occurences of the item to break the file at
* @param string $rawdata the raw data from the original xml file
* @param string $fixedFooter if not null then footer will be this string and not computed
* @returns $arrFiles array of filenames created
**/

//include ('connect_db.php');

include ('src/XmlStreamer.php');

echo '<pre>';

$filein = 'calosc_ExtendedAddress_mazowieckie.xml';

class SimpleXmlStreamer extends XmlStreamer {
    public function processNode($xmlString, $elementName, $nodeIndex) {

        $xml = simplexml_load_string($xmlString);

          $xml_array = unserialize(serialize(json_decode(json_encode((array) $xml), 1)));

           $to_db = array();


            $to_db[$nodeIndex]['IdentyfikatorWpisu']= $xml_array['IdentyfikatorWpisu'];
            $to_db[$nodeIndex]['Imie']= $xml_array['DanePodstawowe']['Imie'];
            $to_db[$nodeIndex]['Nazwisko']= $xml_array['DanePodstawowe']['Nazwisko'];



            if(empty($xml_array['DanePodstawowe']['NIP'] )) {

                $to_db[$nodeIndex]['NIP']= '';
            }else {
                $to_db[$nodeIndex]['NIP']= $xml_array['DanePodstawowe']['NIP'];

            }




            if(empty($xml_array['DanePodstawowe']['REGON'])) {

                $to_db[$nodeIndex]['REGON']= '';
            }else {

                $to_db[$nodeIndex]['REGON'] = $xml_array['DanePodstawowe']['REGON'];
            }

            if(empty($xml_array['DanePodstawowe']['Firma'])) {

                $to_db[$nodeIndex]['Firma']= '';
            }else {

                $to_db[$nodeIndex]['Firma']= $xml_array['DanePodstawowe']['Firma'];
            }


            if(empty($xml_array['DaneKontaktowe']['AdresPocztyElektronicznej'])) {

                $to_db[$nodeIndex]['AdresPocztyElektronicznej']= '';
            }else {

                $to_db[$nodeIndex]['AdresPocztyElektronicznej']= $xml_array['DaneKontaktowe']['AdresPocztyElektronicznej'];


            }

            if(empty($xml_array['DaneKontaktowe']['Telefon'])) {

                $to_db[$nodeIndex]['Telefon']= '';
            }else {
                $to_db[$nodeIndex]['Telefon']= $xml_array['DaneKontaktowe']['Telefon'];
            }



            if (empty($xml_array['DaneAdresowe']['AdresGlownegoMiejscaWykonywaniaDzialalnosci']['Miejscowosc'] )) {

                $to_db[$nodeIndex]['Miejscowosc'] = '';
            } else {
                $to_db[$nodeIndex]['Miejscowosc'] = $xml_array['DaneAdresowe']['AdresGlownegoMiejscaWykonywaniaDzialalnosci']['Miejscowosc'];
            }



            if (isset($xml_array['DaneAdresowe']['AdresGlownegoMiejscaWykonywaniaDzialalnosci']['Ulica'])) {
                if (empty($xml_array['DaneAdresowe']['AdresGlownegoMiejscaWykonywaniaDzialalnosci']['Ulica'])) {

                    $to_db[$nodeIndex]['Ulica'] = '';
                } else {
                    $to_db[$nodeIndex]['Ulica'] = $xml_array['DaneAdresowe']['AdresGlownegoMiejscaWykonywaniaDzialalnosci']['Ulica'];
                }

            } else {
                $to_db[$nodeIndex]['Ulica'] = '';

            }



            if(empty($xml_array['DaneAdresowe']['AdresGlownegoMiejscaWykonywaniaDzialalnosci']['Budynek'])) {

                $to_db[$nodeIndex]['Budynek']= '';
            }else {
                $to_db[$nodeIndex]['Budynek']= $xml_array['DaneAdresowe']['AdresGlownegoMiejscaWykonywaniaDzialalnosci']['Budynek'];
            }

            if(isset($xml_array['DaneAdresowe']['AdresGlownegoMiejscaWykonywaniaDzialalnosci']['Lokal'])) {
                if(empty($xml_array['DaneAdresowe']['AdresGlownegoMiejscaWykonywaniaDzialalnosci']['Lokal'])) {

                    $to_db[$nodeIndex]['Lokal']= '';
                }else {
                    $to_db[$nodeIndex]['Lokal']= $xml_array['DaneAdresowe']['AdresGlownegoMiejscaWykonywaniaDzialalnosci']['Lokal'];
                }

            } else {

                $to_db[$nodeIndex]['Lokal']= '';
            }


            if(empty($xml_array['DaneAdresowe']['AdresGlownegoMiejscaWykonywaniaDzialalnosci']['KodPocztowy'])) {

                $to_db[$nodeIndex]['KodPocztowy']= '';
            }else {
                $to_db[$nodeIndex]['KodPocztowy']= $xml_array['DaneAdresowe']['AdresGlownegoMiejscaWykonywaniaDzialalnosci']['KodPocztowy'];
            }


            if(empty($xml_array['DaneAdresowe']['AdresGlownegoMiejscaWykonywaniaDzialalnosci']['Poczta'])) {

                $to_db[$nodeIndex]['Poczta']= '';
            }else {
                $to_db[$nodeIndex]['Poczta']= $xml_array['DaneAdresowe']['AdresGlownegoMiejscaWykonywaniaDzialalnosci']['Poczta'];
            }

            if(empty($xml_array['DaneAdresowe']['AdresGlownegoMiejscaWykonywaniaDzialalnosci']['Gmina'])) {

                $to_db[$nodeIndex]['Gmina']= '';
            }else {
                $to_db[$nodeIndex]['Gmina']= $xml_array['DaneAdresowe']['AdresGlownegoMiejscaWykonywaniaDzialalnosci']['Gmina'];
            }

            if(empty($xml_array['DaneAdresowe']['AdresGlownegoMiejscaWykonywaniaDzialalnosci']['Powiat'])) {

                $to_db[$nodeIndex]['Powiat']= '';
            }else {
                $to_db[$nodeIndex]['Powiat']= $xml_array['DaneAdresowe']['AdresGlownegoMiejscaWykonywaniaDzialalnosci']['Powiat'];
            }

            if(empty($xml_array['DaneAdresowe']['AdresGlownegoMiejscaWykonywaniaDzialalnosci']['Wojewodztwo'])) {

                $to_db[$nodeIndex]['Wojewodztwo']= '';
            }else {
                $to_db[$nodeIndex]['Wojewodztwo']= $xml_array['DaneAdresowe']['AdresGlownegoMiejscaWykonywaniaDzialalnosci']['Wojewodztwo'];
            }

            if(empty($xml_array['DaneDodatkowe']['DataRozpoczeciaWykonywaniaDzialalnosciGospodarczej'])) {

                $to_db[$nodeIndex]['DataRozpoczeciaWykonywaniaDzialalnosciGospodarczej']= '';
            }else {
                $to_db[$nodeIndex]['DataRozpoczeciaWykonywaniaDzialalnosciGospodarczej']= $xml_array['DaneDodatkowe']['DataRozpoczeciaWykonywaniaDzialalnosciGospodarczej'];
            }


            if(empty($xml_array['DaneDodatkowe']['MalzenskaWspolnoscMajatkowa'])) {

                $to_db[$nodeIndex]['MalzenskaWspolnoscMajatkowa']= '';
            }else {
                $to_db[$nodeIndex]['MalzenskaWspolnoscMajatkowa']= $xml_array['DaneDodatkowe']['MalzenskaWspolnoscMajatkowa'];
            }

            if(empty($xml_array['DaneDodatkowe']['Status'])) {

                $to_db[$nodeIndex]['Status']= '';
            }else {
                $to_db[$nodeIndex]['Status']= $xml_array['DaneDodatkowe']['Status'];
            }

            if(empty($xml_array['DaneDodatkowe']['KodyPKD'])) {

                $to_db[$nodeIndex]['KodyPKD']= '';
            }else {
                $to_db[$nodeIndex]['KodyPKD']= $xml_array['DaneDodatkowe']['KodyPKD'];

            }


//            $i++;
//
//        }



//
      include('connect_db.php');
//
//
        foreach ($to_db as $valuedb) {


            $datatodb = array(

                $valuedb['IdentyfikatorWpisu'],
                $valuedb['Imie'],
                $valuedb['Nazwisko'],
                $valuedb['NIP'],
                $valuedb['REGON'],
                $valuedb['Firma'],
                $valuedb['AdresPocztyElektronicznej'],
                $valuedb['Telefon'],
                $valuedb['Miejscowosc'],
                $valuedb['Budynek'],
                $valuedb['Lokal'],
                $valuedb['KodPocztowy'],
                $valuedb['Poczta'],
                $valuedb['Gmina'],
                $valuedb['Powiat'],
                $valuedb['Wojewodztwo'],
                $valuedb['DataRozpoczeciaWykonywaniaDzialalnosciGospodarczej'],
                $valuedb['MalzenskaWspolnoscMajatkowa'],
                $valuedb['Status'],
                $valuedb['KodyPKD'],


            );


//  var_dump($datatodb);


            $sql = "INSERT INTO dolnoslaskie (IdentyfikatorWpisu , Imie  , Nazwisko , NIP , REGON , Firma , AdresPocztyElektronicznej , Telefon , Miejscowosc , Budynek , Lokal , KodPocztowy , Poczta , Gmina , Powiat , Wojewodztwo , DataRozpoczeciaWykonywaniaDzialalnosciGospodarczej , MalzenskaWspolnoscMajatkowa , Status , KodyPKD  )

 VALUES (? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,?  )";
            $conn->prepare($sql)->execute($datatodb);


      }

    }

}




$streamer = new SimpleXmlStreamer("calosc_ExtendedAddress_dolnoslaskie.xml" );
$streamer->parse();
//

//
//$xml = simplexml_load_file( $filein );
//
//$i=1;
//foreach( $xml->InformacjaOWpisie as $foo ) {
//
//  //  var_dump($foo);
//
//    $fileout = $i . '.xml';
//    $fh = fopen( $fileout, 'w') or die ( "can't open file $fileout" );
//    fwrite( $fh, $foo->asXML() );
//    fclose( $fh );
//    $i++;
//}
