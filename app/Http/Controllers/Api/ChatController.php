<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\msgModel;
use App\Events\msgSent;

class ChatController extends Controller
{
    public function fetchMessages()
    {
        return msgModel::with('user')->orderBy('created_at', 'DESC')->paginate(15);
    }}
