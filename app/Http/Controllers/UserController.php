<?php

namespace App\Http\Controllers;

use App\Models\ConnectionLog;
use App\Models\Server;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function register(Request $request) {
        try {
            $request->validate([
                'username' => 'required'
            ]);
        } catch (Exception $e) {
            return Inertia::render('Register', [
                'message' => str($e->getMessage())
            ]);
        }
        

        function isValueInArray($array, $attribute, $value) {
            foreach ($array as $item) {
                if (isset($item[$attribute]) && $item[$attribute] === $value) {
                    return true;
                }
            }
            return false; // Value not found
        }
        
        $WHITELIST_FILE = '/home/shariyl/Works/Minecraft-Register/whitelists.json';
        $SESSION_NAME = 'minecraft-fabric';

        // Parse JSON string to array
        $data = json_decode(file_get_contents($WHITELIST_FILE), true);

        if (isValueInArray($data, 'name', $request->username) ) {
            return Inertia::render('Register', [
                'message' => "Username sudah terdaftar"
            ]);
        }

        $command = "screen -R $SESSION_NAME -X stuff 'whitelist add $request->username\n'";
        shell_exec($command);

        return Inertia::render('Register', [
            'message' => "Username whitelisted"
        ]);
    }
    
}
