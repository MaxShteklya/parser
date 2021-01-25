<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use cn13\simplehtmldom\SimpleHTMLDom;
use backend\models\Auctions;

/**
 * Parser
 */
class Parser extends Model
{
    public function get_curl($url, $referer = 'https://www.google.com')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0");
        curl_setopt($ch, CURLOPT_REFERER, $referer);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    public function startParsing($url){
        $html = $this->get_curl($url);
        $hrefs = $this->createAuctions($html);
        if(!empty($hrefs)) $this->parseCars($hrefs, $url);
        else echo "empty";
    }

    public function createAuctions($html){
        $urls = array();
        $dom = SimpleHTMLDom::str_get_html($html);;
        $auctions_categories = $dom->find('.float-md-left');
        foreach ($auctions_categories as $auctions){
            $category = "Room sale";
            if($auctions->children[0]->plaintext == $category){
                $auction = $auctions->find('.w-90');
                foreach ($auction as $block) {
                    $name = trim($block->find('.lh-20', 0)->plaintext);
                    $href = $block->find('.sale-access-href', 0)->href;
                    $date = trim($block->find('.float-right', 0)->plaintext);
                    $lots = preg_replace('/[^0-9]/', '', $block->find('.text-graynorm', 0)->plaintext);
                    $place = trim($block->find('.text-prim', 0)->plaintext);
                    $auction_id = array_slice(explode('/', $href), -1)[0];

                    $exists = Auctions::find()->where( [ 'room_id' => $auction_id ] )->exists();
                    array_push($urls, $href);
                    if(!$exists) {
                        $auction = new Auctions();
                        $auction->room_id = $auction_id;
                        $auction->room_name = $name;
                        $auction->room_alias = $href;
                        $auction->room_date = $date;
                        $auction->room_lots = $lots;
                        $auction->room_place = $place;
                        if($auction->save()){
                            //array_push($urls, $href);
                        }
                    }
                }
            } else continue;
        }

        return $urls;
    }

    public function parseCars($hrefs, $url){
        foreach ($hrefs as $href){ // EVERY ROOM
            $href = str_replace('/en/', '', $href);
            $link = $url.$href;

            $html = $this->get_curl($link);
            $json = stristr($html, "window.Alcopa.searchResultsJSONString = '");
            $json = stristr($json, "';", true);
            $json = str_replace("window.Alcopa.searchResultsJSONString = '", '', $json);
            $json = str_replace("';", '', $json);
            $json = preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
                return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UTF-16BE');
            }, $json);
            $json = str_replace('\\', '', $json);

            $all_cars = json_decode($json);
            //exit();
            foreach ($all_cars as $cars_category){ // EVERY CATEGORY
                foreach ($cars_category as $car){ // EVERY CAR
                    echo "<pre>";
                    var_dump($car->category);
                    break;
                }

            }
            //echo "NEW ROOM";
            //exit();




            //break;

        }
    }

}
