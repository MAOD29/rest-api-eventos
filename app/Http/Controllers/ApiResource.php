<?php namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

trait ApiResource {

    public function all(){
        if (! Request()->expectsJson()) {
            return response()->json(['message' => 'No json'], 401, []);
        }

        $model = self::MODEL;
        $folderName = self::FOLDER;

        $data = $model::paginate(6);

        $data->map(function ($item) use($folderName){

            $item->image =  asset("storage/$folderName/$item->image"); 
            
        });
        return response()->json(['message' => 'ok', 'data' => $data], 200);
    }
 

    public function getOne(Model $model){
        
        if (! Request()->isJson()) {
            return response()->json(['message' => 'No json'], 401, []);
        }

        $folder = self::FOLDER;
        $model->image =  asset("storage/$folder/$model->image"); 
        return response()->json(['message' => 'ok', 'data' => $model], 200);

    }
    public function add(){

        $model = self::MODEL;

        Request()->merge(['user_id' => Request()->user()->id]);
        
        $this->validate(Request(),$model::$rules);
        
        $file = Request()->file('image');
        $fileName = $this->uploadImage($file);

        $requestData = Request()->all();
        $requestData['image'] = $fileName;

        $data =  $model::create( $requestData);
        return response()->json(['message' => 'ok', 'data' => $data], 201);
    }
    public function change(Model $model){

        $this->authorize('view',Request()->user(),$model);

        $user =  Request()->user();
        Request()->merge(['user_id' => $user->id]);

        $this->validate(Request(),$model::$rules);

        $file = Request()->file('image');
        $fileName = $this->uploadImage($file);

        $requestData = Request()->all();
        $requestData['image'] = $fileName;

        $model->update( $requestData);
        return response()->json(['message' => 'ok', 'data' => $model], 200);
    }

    public function delete(Model $model){
        if (! Request()->isJson()) {
            return response()->json(['error' => 'No json'], 401, []);
        }

        $this->authorize('view',Request()->user(),$model);
        $model->delete();
        return response()->json(['message' => 'ok', 'data' => $model], 200);
    }

    
    public function uploadImage($file){

        $folder = self::FOLDER;

        $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

        Storage::disk('public')->put("$folder/$fileName",  File::get($file));
        return $fileName;
    }
   
    
}