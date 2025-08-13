<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Cookie;
use Livewire\Component;


class Cookies extends Component
{

    public $cookieText;
    public $local;

    public function render()
    {
        return view('livewire.cookies');
    }

    public function mount(){
        $this->cookieText = Cookie::get('example', 'No hay cookie');
        
    }  

    public function setCookie(){

        $texto = "texto";

        Cookie::queue('example', $texto);


        $this->cookieText = $texto;

    } 
        //arrays implementar experimentar 



}