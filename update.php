use App\User;
use Illuminate\Http\Request;

class UpdateController
{

  public function update(Request $request, User $user)
   {

   //Validate the data
   //Make them nullable because they are all optional
   
      $data = request()->validate([
	  'user_id' => 'integer', 
          'location' => 'string|nullable',
          'picture' => 'image|nullable',
          'about' =>  'string|nullable',
          'DOB' => 'date|nullable',
      ]);
      
    //Check if picture input was filled
    //Save the picture on the local storage i.e. profile directory (or any storage except the database) 
    //Save the link in the database
    //Else do nothing

      if($request->hasFile('picture')){
         $picturePath = $request->picture->store('profile', 'public');

         $profileArray = ['picture' => $picturePath];
      }
    //Merge the validated data with profile array or empty array if profile input was not filled
    
        $all = array_merge(
                $data,
                $profileArray ?? []
            );
      //Update data and filter off the array elements without value using `array_filter()`
      //Thereby updating only the inputs that were filled
      //Note that the `profile()` method is the eloquent relationship of 'User` model with `Profle` model
      
      auth()->user()->profile()->update(array_filter($all));
      
     
      return back();

    }
  
}
