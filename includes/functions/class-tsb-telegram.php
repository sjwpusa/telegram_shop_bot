<?php
namespace Plugin_Name_Dir\Includes\Functions;
use \Longman\TelegramBot\Entities\InlineKeyboard;
use \Telegram\Bot\Api;
use Telegram\Bot\FileUpload\InputFile;

class Tsb_Telegram
{
    protected $options;
    protected $api_token;
    protected $data;
    protected $telegram_api_instance;
    public function __construct($input)
    {
        $this->options=get_option('TSB_settings');
        $this->api_token=$this->options['api_token'];
        $this->data=json_decode($input, true);

        self::get_input_message();
    }

    protected function get_input_message()
    {
        $telegram=$this->get_telegram_api_instance();
        $return = array();
        $return['input'] = $this->data;
        $return['text'] = $this->data['message']['text'];
        $return['from'] = $this->data['message']['from'];
        $return['chat_id'] = $this->data['message']['from']['id'];
        $return['message_id'] = $this->data['message']['message_id'];
        if (isset($this->data['callback_query']))
        {
            $callback_query = $this->data['callback_query'];
            $return['text'] = $callback_query['message']['text'];
            $return['from'] = $callback_query['from'];
            $return['chat_id'] = $callback_query['from']['id'];
            $return['message_id'] = $callback_query['message']['message_id'];
            $return['data'] = $callback_query['data'];
            $return['callback_query_id'] = $callback_query['id'];


            if (strpos($return['data'], 'product_main_cat_' ) !== false)
            {
                $product_main_cat_id=str_replace('product_main_cat_', '', $return['data']);
                $telegram->editMessageReplyMarkup([
                    'chat_id' =>  $return['chat_id'],
                    'message_id' => $return['message_id'],
                    'reply_markup' =>$this->get_keyboard('product_sub_cat',1,true,false,array('main_cat_id' => $product_main_cat_id))
                ] );
            }

            if (strpos($return['data'], 'product_child_cat_' ) !== false)
            {
                $product_child_cat_id=str_replace('product_child_cat_', '', $return['data']);
                $telegram->sendChatAction([
                    'chat_id' =>  $return['chat_id'],
                    'action' => 'upload_photo',
                        ]);
               $telegram->sendPhoto([
                   'chat_id' =>  $return['chat_id'],
                   'photo' => new InputFile('http://www.inspire-travel.com/wp-content/uploads/2020/01/Waterfalls-1050x748.jpg')  ,
                   'caption' =>   $product_child_cat_id,
               ] );
            }

        }
        else
        {
            switch ($return['text'])
            {
                case '/start':
                    $telegram->sendMessage([
                        'chat_id' =>  $return['chat_id'],
                        'text' => $this->options['start_command'],
                        'reply_markup' =>$this->get_keyboard('main',null,true,false)
                    ]);
                    break;

                case 'محصولات':
                    $telegram->sendMessage([
                        'chat_id' =>  $return['chat_id'],
                        'text' => 'لطفا یکی از دسته های زیر را نتخاب نمایید :',
                        'reply_markup' =>$this->get_keyboard('product_main_cat',null,true,false)
                    ]);
                    break;
            }
        }
    }


    public function get_keyboard(string $step,int $level=null, bool $resize_keyboard,bool $one_time_keyboard,array $args=null)
    {
        switch ($step)
        {
            case 'main':
                 return  json_encode([
                    'keyboard' => [
                        ['🛒 سبد خرید', 'محصولات'],
                        [' 🗄️ سفارشات من', '🔍 جستجوی کالا'],
                        ['✉️ ارسال پیام', ' 🗳️ پیگیری سفارش'],
                        ['🛡️ ارتباط با ما', '☃️ پروفایل'],
                    ],
                    'resize_keyboard' => $resize_keyboard,
                    'one_time_keyboard' => $one_time_keyboard,
                ]);
                break;

            case 'product_main_cat':
               $all_categories = get_categories(array(
                    'taxonomy'     => 'product_cat',
                    'orderby'      => 'name',
                    'hide_empty' => 0,
                    'parent'  => 0
                ));
                $items = array_map(function ($cat) {
                    if ($cat->name != 'Uncategorized')
                    {
                        return [
                            'text'          => $cat->name,
                            'callback_data' =>'product_main_cat_'.$cat->term_id,
                        ];
                    }
                }, $all_categories);

                $max_per_row  = 2; // or however many you want!
                $per_row      = sqrt(count($items));
                $rows         = array_chunk($items, $per_row === floor($per_row) ? $per_row : $max_per_row);
                return  $reply_markup = new InlineKeyboard(...$rows);
                break;

            case 'product_sub_cat':
               $all_categories = get_categories(array(
                    'taxonomy'     => 'product_cat',
                    'orderby'      => 'name',
                    'hide_empty' => 0,
                    'child_of'  => $args['main_cat_id']
                ));
                $items = array_map(function ($cat) {
                    if ($cat->name != 'Uncategorized')
                    {
                        return [
                            'text'          => $cat->name,
                            'callback_data' =>'product_child_cat_'.$cat->term_id,
                        ];
                    }
                }, $all_categories);

                $max_per_row  = 2; // or however many you want!
                $per_row      = sqrt(count($items));
                $rows         = array_chunk($items, $per_row === floor($per_row) ? $per_row : $max_per_row);
                return  $reply_markup = new InlineKeyboard(...$rows);
                break;
        }

    }


    public function get_telegram_api_instance()
    {
        if ( is_null( ( $this->telegram_api_instance ) ) )
        {
            $this->telegram_api_instance = new Api($this->api_token);
        }
        return $this->telegram_api_instance;
    }
}
