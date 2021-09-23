<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use NotificationChannels\ChatAPI\ChatAPIChannel;
use NotificationChannels\ChatAPI\ChatAPIMessage;

class WaBlash extends Notification
{
    // use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    protected $message;
    public function __construct($message)
    {   
        $this->message=$message;
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public static function via($notifiable)
    {
        return [ChatAPIChannel::class];
    }


    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toChatAPI($notifiable)
    {   
        $GLOBALS['_ENV']['CHATAPI_TOKEN']=config('setting_proepdeskel.wa.CHATAPI_TOKEN');
        $GLOBALS['_ENV']['CHATAPI_URL']=config('setting_proepdeskel.wa.CHATAPI_URL');
        config(['services.chatapi.token'=>config('setting_proepdeskel.wa.CHATAPI_TOKEN','')]);
        config(['services.chatapi.api_url'=>config('setting_proepdeskel.wa.CHATAPI_URL','')]);


        return ChatAPIMessage::create()
            ->to($notifiable->routes['chatapi']) // your user phone
            // ->file(public_path('dist-web/logo.png'),'logo.png','sss')
            ->content($this->message['content']);
            
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
