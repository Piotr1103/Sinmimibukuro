<?php
namespace app\controller;

use app\BaseController;
use app\model\About as AboutModel;
use app\model\Bulletin as BulletinModel;
use app\model\Carousel as CarouselModel;

class Index extends BaseController
{
	public function index()
	{
		$order = request()->param('order') ? request()->param('order') : 'desc';
		$about = AboutModel::order('aid')->select();
		$cont = BulletinModel::where('status', 1)->order('bid', $order)->paginate(5);
		$carousel = CarouselModel::order('cid', 'desc')->limit(10)->select();

		return view('index', [
			'about' => $about,
			'carousel' => $carousel,
			'cont' => $cont,
			'aside' => '<div class="bg-info">江戸時代的南町奉行根岸鎮衛將當時社會上流傳的一些聽起來不可思議、匪夷所思的流言蜚語先記錄下來，待日後琢磨查證，其隨筆札記就叫做"耳袋"(也作"耳囊")。而《新耳袋》是恐怖短篇故事集，為日本靈異作家木原浩勝與中山市朗共同編寫。他們致力蒐集日本各地網友投稿的真實體驗故事，皆為現代都會中發生的神秘事件，例如出租公寓發生的怪事、照片出現詭異的人影、詭異自殺事件等等。整個系列共有十夜(十本)。原本是以「百物語」形式出版，但作者表示出版之後，發生一連串不可思議事件，因為人們相信只要連續看完一百則怪談就會發生怪事，陸續有讀者反應看完真有靈異事件發生，所以經過刪減後成為九十九則靈異故事的《怪談新耳袋》（角川文庫版跋）。台灣的東販出版社只引進了第一夜跟第二夜，而且只出了一刷就絕版了。出版社的官方說法是銷量不如預期，但新耳袋的支持者認為應該有更多的故事。做為一個怪談迷，像新耳袋這種平淡裡帶點小恐怖的故事是最吸引人的。不去探討故事的真實性，而就單純去享受這些故事所帶來的小小刺激感，這也是新耳袋的一個重要原則。這個系列日文原版有十本，每本99個故事。然而，中文版只由台灣省東販出版社出版了前兩夜之后，就沒再繼續出版了，而且前兩夜也很快就絕版了，各種流言四起(有人說翻譯者翻完後遭遇靈異現象，所以不敢再翻了)。為了能夠讀到更完整的新耳袋，我在日本亞馬遜買到了角川文庫出版的新耳袋，也開始學習很久沒碰的日文。但顯然這並不是可以一蹴而幾的。新耳袋的翻譯網路上偶爾可以看到一些網友自己翻譯的幾篇零碎段落，但是實在不足以滿足需求。獨樂樂不如眾樂樂，我專門去找認識的店把這幾本書掃描起來，跟聲友們分享。說不定讀的人多了，就有人願意來翻譯了。</div>',
		]); 
	}

	public function hello($name = 'ThinkPHP6')
	{
		return 'hello,' . $name;
	}
}
