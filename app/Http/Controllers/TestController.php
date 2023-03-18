<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Cion\TextToSpeech\Facades\TextToSpeech;


class TestController extends Controller
{
    public $api_header = [];

    public function __construct() {
        $this->api_header = [
            'customer-id'   => env('CUSTOMER_ID'),
            'x-api-key'     => env('GTP_KEY')
        ];
    }

    public function index()
    {
        return Inertia::render('Index');
    }

    public function storeAudio(Request $request)
    {

        $file = $request->file;
        $path = "audios";
        $name = "sound-" . rand(0,100000);

        $file = $request->file("file")->storePubliclyAs(
            $path,
            $name . '.' . $request->file("file")->extension(),
            "public"
        );

        $whisper_transcriptions = $this->callWhisperApi($file);

        $chat_gpt = $this->callGptApi($whisper_transcriptions);

        $aws_tts = TextToSpeech::saveTo('public/response/'.$name.'.mp3')->convert($chat_gpt);

        return asset("storage/response/".$name.".mp3");
    }

    protected function callWhisperApi($file)
    {
        $whisper_transcriptions = Http::attach(
            'file', fopen(storage_path("app/public/" . $file), 'r')
        )
        ->withHeaders($this->api_header)
        ->post('https://experimental.willow.vectara.io/v1/audio/transcriptions', [
            'model' => 'whisper-1',
        ])->json();
            // dd($whisper_transcriptions, $file, $this->api_header);
        return  $whisper_transcriptions['text'];
    }

    protected function callGptApi($whisper_transcriptions)
    {
        $chat_gpt = Http::withHeaders($this->api_header)
        ->post('https://experimental.willow.vectara.io/v1/chat/completions',[
            'model' => 'gpt-3.5-turbo', 'messages' => [['role' => 'user',
            'role' => 'system',
            'content' => 'You are an assistant. reply only in arabic language .',
            'content' => $whisper_transcriptions]],
        ])->json();

        return  $chat_gpt['choices'][0]['message']['content'];
    }
}
