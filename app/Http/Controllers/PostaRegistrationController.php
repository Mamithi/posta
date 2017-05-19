<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Mail;
use Person;
use AfricasTalkingGateway;

class PostaRegistrationController extends Controller
{

     public function getUserData(Request $request){
        
        $id = $request->input('id');
        
        if(count($id) > 0 ){
            $data = DB::table('persons')->select('FirstName', 'LastName', 'Email', 'Phone')->where(['id'=>$id])->get();
            if(count($data) > 0){
                foreach($data as $values){
                    $FirstName = $values->FirstName;
                    $LastName = $values->LastName;
                    $Email = $values->Email;
                    $Phone = $values->Phone;
                }
                return response(array(
                     "FirstName" => $FirstName,
                     "LastName" => $LastName,
                     "Email" => $Email,
                     "Phone" => $Phone,
                ));
            }else{
                return response(array(
                    "Message" => "This user is not registered with Posta Kenya",
                    "code" => 200,
                    "status" => "fail",
                )); 
            }
        }else{
            return response(array(
                    "Message" => "Please neter both code and box",
                    "code" => 200,
                    "status" => "fail",
                )); 
        }
      }

    public function verifyPhone(Request $request){
             $codeNum = $request->input('code');
             $phoneNum = $request->input('phone');
             $codes = DB::table('admins')->where(['Code'=>$codeNum, 'Phone' =>$phoneNum])->get();
             if(count($codes) > 0){
                return response(array(
                "Message" => "You have entered the right code",
                "code" => 200,
                "status" => "success",
                ));
            }else{
             return response(array(
                "Message" => "Please enter the code that was sent to you",
                "code" => 200,
                "status" => "fail",
                ));
         }
    }


    public function addBox(Request $request){
        $id = $request->input('id');
        $box = $request->input('box');
        $codeNum = $request->input('codeNum');
        if(count($id) > 0){
            $add=DB::table('persons')
                    ->where('id', $id)
                    ->update(['Box' => $box, 'CodeNumber' => $codeNum]);
            if(count($add) > 0){
              return response(array(
                    "Message" => "Box and Code Updated successfully",
                    "code" => 200,
                    "status" => "success",
                ));
            }else{
                return response(array(
                "Message" => "Box and Code Not updated",
                "code" => 200,
                "status" => "fail",
                ));
            }
        }else{
            return response(array(
                "Message" => "This id does not exist",
                "code" => 200,
                "status" => "fail",
                ));
        }
    }

    public function subscribe(Request $request){
        $id = $request->input('id');
        $subscribe = $request->input('subscribe');
       
        if(count($id) > 0){
            $add=DB::table('persons')
                    ->where('id', $id)
                    ->update(['Subscribe' => $subscribe]);
            if(count($add) > 0){
              return response(array(
                    "Message" => "You have successfully subscribed to our notifications",
                    "code" => 200,
                    "status" => "success",
                ));
            }else{
                return response(array(
                "Message" => "Your subscription failed",
                "code" => 200,
                "status" => "fail",
                ));
            }
        }else{
            return response(array(
                "Message" => "This id does not exist",
                "code" => 200,
                "status" => "fail",
                ));
        }
    }



    public function notifications(Request $request){
        
        $box = $request->input('box');
        $code = $request->input('code');
        if(count($box) > 0  && count($code) > 0){
            $data = DB::table('alerts')
                        ->select('Box', 'Code', 'Alert', 'Message', 'created_at')->where(['Box'=>$box, 'Code'=>$code])
                        ->orderBy('id', 'desc')
                        ->get();
            if(count($data) > 0){
                return response(array(
                     'notifications' =>$data-> toArray()
                ));
            }else{
                return response(array(
                    "Message" => "You have no notifications",
                    "code" => 200,
                    "status" => "fail",
                )); 
            }
        }else{
            return response(array(
                    "Message" => "Please neter both code and box",
                    "code" => 200,
                    "status" => "fail",
                )); 
        }
      }


      public function getBox(Request $request){
        
        $id = $request->input('id');

        if(count($id) > 0){
            $data = DB::table('persons')->select('Box', 'CodeNumber')->where(['id' => $id])->get();
            if(count($data) > 0){
                foreach($data as $values){
                    $Box = $values->Box;
                    $CodeNumber = $values->CodeNumber;
                 }
                return response(array(
                     "box" => $Box,
                     "code" => $CodeNumber 
                ));
            }else{
                return response(array(
                    "Message" => "No Data",
                    "code" => 200,
                    "status" => "fail",
                )); 
            }
        }else{
            return response(array(
                    "Message" => "This id does not exist",
                    "code" => 200,
                    "status" => "fail",
                )); 
        }
      }
    public function registerAdmin(Request $request)
    {
        $firstName = $request->input('firstName');
        $lastName = $request->input('lastName');
        $phone = $request->input('phone');
        $email = $request->input('email');
        $password = $request->input('password');
        $password2 = $request->input('password2');
        $sign = "+";
        if(strlen($firstName) < 1){
            return response(array(
                "Message" => "Please enter your first name",
                "code" => 209,
                "status" => "Fail",
             ));
        }else if(strlen($lastName) < 1){
            return response(array(
                "Message" => "Please enter your second name",
                "code" => 209,
                "status" => "Fail",
             ));
        }else if(strlen($phone) != 10 && strlen($phone) != 13 ){
            return response(array(
                "Message" => "Please enter a valid phone number",
                "code" => 209,
                "status" => "Fail",
             ));
        }else if((strlen($phone) == 10 && ($phone[0] != 0))){
               return response(array(
                "Message" => "Please enter a valid phone number",
                "code" => 209,
                "status" => "Fail",
             ));  
        }
        else if((strlen($phone) == 13 && ($phone[0] != $sign))){
               return response(array(
                "Message" => "Please enter a valid phone number",
                "code" => 209,
                "status" => "Fail",
             ));  
        }
        else if(filter_var($email, FILTER_VALIDATE_EMAIL) === false ){
            return response(array(
                "Message" => "Please enter a valid Email",
                "code" => 209,
                "status" => "Fail",
             ));
        }
        else if(strcmp($password, $password2) ){
            return response(array(
                "Message" => "Your passwords dont match",
                "code" => 209,
                "status" => "Fail",
             ));
        }else if(strlen($password) < 1 || strlen($password2) < 1){
            return response(array(
                "Message" => "Please enter your password",
                "code" => 209,
                "status" => "Fail",
             ));
        }

        
        else{
            try{
            $code = rand ( 10000 , 99999 );
              
            
            $users = DB::table('admins')->insert(['FirstName' => $firstName, 'LastName' => $lastName, 'Phone' => $phone, 'Email' => $email, 'Password' => $password, 'Code' => $code]);
           
            $this->sendEmail($email);
            $this->send($phone, $code);
            if($users){
            
            return response(array(
                    "Message" => "Registration successful",
                    "code" => 200,
                    "status" => "success",
                ));


            $user = array(
                    'email' => $email,
                    'subject' => 'Verification Code',
                    
                );
            // $sent = Mail::raw('Please follow this link to verify your account  http://localhost/Posta/verify.php', function($message) use ($user){

            //     $message->to($user['email']);
            //     $message->subject($user['subject']);
                
            // });


            }else{
            return response(array(
                    "Message" => "Registration failed",
                    "code" => 500,
                    "status" => "fail",
                    ));
            }
        }catch(\Illuminate\Database\QueryException  $e){
                return response(array(
                    'Message' => 'The Email or Phone Number already registered',
                    'status' => 'Failed',
                    'code' => 204,
                    ));
            }
        }
    }

    public function transactionData(Request $request)
    {
        $person_id = $request->input('person_id');
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $phone = $request->input('phone');
        $email = $request->input('email');
        $type = $request->input('type');
        $reference = $request->input('reference');
        $description = $request->input('description');
        $amount = $request->input('amount');
        $transaction_id = "null";
        $status = "queued";
      
       
            $users = DB::table('transactions')->insert(['FirstName' => $first_name, 'LastName' => $last_name, 'Phone' => $phone, 'Email' => $email, 'Type' => $type, 'Description' => $description, 'Amount' => $amount, 'Reference'=>$reference, 'PersonId' => $person_id, 'transaction_id' => $transaction_id, 'status' => $status]);
           
          
            if($users){
            
            return response(array(
                    "Message" => "Data Saved successfully",
                    "code" => 200,
                    "status" => "success",
                ));
           

            }else{
            return response(array(
                    "Message" => "Data not saved",
                    "code" => 500,
                    "status" => "fail",
                    ));
            }
      
        
    }
    public function updateCredits(Request $request){
        $personId = $request->input('personId');
        $amount = $request->input('amount');
        $getData = DB::table('persons')
                    ->select('credits', 'usedCredits')
                    ->where('id', $personId)
                    ->get();
        foreach ($getData as $value) {
                $credits = $value->credits;
                $usedCredits = $value->usedCredits;
        }
        $updatedCredit = $credits + $amount;
        $remCredits = $updatedCredit - $usedCredits;
        $data = DB::table('persons')
                    ->where('id', $personId)
                    ->update(['credits' => $updatedCredit]);
        if(count($data) > 0){

            return response(array(
                "Message" => "You have successfully bought " .$amount. " credits and your new credit balance is ". $remCredits. ". Go back home or click verify to verify box number",
                "code" => 200,
                "status" => "success",
                ));
        }else{
            return response(array(
                "Message" => "Dear customer your purchase of" .$amount. " credits has failed. Please try again later",
                "code" => 200,
                "status" => "fail"
                ));
        }
    }
    public function getTransactionData(Request $request){
        $person_id = $request->input('person_id');
        if(count($person_id) > 0){
                $data = DB::table('transactions')->select('id','FirstName', 'LastName', 'Email', 'Phone', 'Amount', 'Type', 'Reference', 'Description')->where(['PersonId' => $person_id])->get();
                $len = count($data);
                for($i=0;$i<$len;$i++){
                    $FirstName = $data[$len-1]->FirstName;
                    $LastName = $data[$len-1]->LastName;
                    $Email = $data[$len-1]->Email;
                    $Phone = $data[$len-1]->Phone;
                    $Type = $data[$len-1]->Type;
                    $Reference = $data[$len-1]->Reference;
                    $Description = $data[$len-1]->Description;
                    $Amount = $data[$len-1]->Amount;
                    return response(array(
                        'FirstName' => $FirstName,
                        'LastName' => $LastName,
                        'Email' => $Email,
                        'Phone' => $Phone,
                        'Type' => $Type,
                        'Reference' => $Reference,
                        'Description' => $Description,
                        'Amount' => $Amount,
                    ));
                }
               
             
                        }else{
            return response(array(
                    "Message" => "This person does not exist",
                    "code" => 200,
                    "status" => "fail",
            ));
        }
    }
    public function updateTrackingId(Request $request){
        $trackingId = $request->input('trackingId');
        $reference = $request->input('reference');
        $data = DB::table('transactions')
                    ->where('Reference', $reference)
                    ->update(['transaction_id' => $trackingId]);
        if(count($data) > 0){
            return response(array(
                    "Message" => "This is your tracking id",
                    "code" => 200,
                    "status" => "success"
                ));
        }else{
            return response(array(
                    "Message" => "Tracking id not updated",
                    "code" => 200,
                    "status" => "fail"
                ));
        }


    }

     public function loginAdmin(Request $request){
                    $remember = false;
                    $email = $request->input('email');
                    $phone = $request->input('phone');
                    $password = $request->input('password');
                    $remember_me = $request->input('remember');
                    
                    $check = 0;
                    
                    
                    
                    if(count($phone) > 0){
                        $usePhone = DB::table('admins')->where(['Phone'=>$phone, 'Password'=>$password], $remember)->get();
                        if(count($usePhone) > 0){
                            $check = 1;
                        }
                    }
                    if(count($email) > 0){
                        $useEmail = DB::table('admins')->where(['Email'=>$email, 'Password'=>$password], $remember)->get();
                         if(count($useEmail) > 0){
                            $check = 1;
                        }
                    }
                    if($check > 0){
                        
                        $persons = DB::table('admins')->select('FirstName', 'LastName', 'id')->where(['Email'=>$email])->get();
                        $persons2 = DB::table('admins')->select('FirstName', 'LastName', 'id')->where(['Phone'=>$phone])->get();
                        if((count($persons) > 0)){
                     
                        foreach ($persons as $member)
                            {
                                $FirstName = $member->FirstName;
                                $LastName = $member->LastName;
                               
                                $id = $member->id;
                            }

                        }else{
                         
                        foreach ($persons2 as $member)
                            {
                                $FirstName = $member->FirstName;
                                $LastName = $member->LastName;
                               
                                $id = $member->id;
                            } 
                        }

                        // $sessionValue = $request->session()->put('id', $id);
                        // if($request->session()->has('id')){
                        //     $sessionValue = $request->session()->get('id');
                           
                        // }
                                        
                        return response(array(
                            'Message' => 'Log in successful',
                            'status' => 'success',
                            'FirstName' => $FirstName,
                            'LastName' => $LastName,
                         
                            'id' => $id,
                            // 'session' => $sessionValue,

                           ),200);
                    }else{
                        return response(array(
                            "Message" => "Authentication failed, details provided are invalid",
                            'status' => 'fail'
                            ));
                        
                    }

        }
   public function sendEmail($email){
    $token = str_random(50);
            $user = array(
                    'email' => $email,
                    'subject' => 'Activate your account',
                    
                );
            $sent = Mail::raw('Please follow this link to activate your account http://localhost/Posta/activate.php?email='.$email. '&token='.$token, function($message) use ($user){

                $message->to($user['email']);
                $message->subject($user['subject']);
                
            });
   }

   public function send($phone, $code){
                require_once(app_path(). '/functions/AfricasTalkingGateway.php');
                $username   = "LOGIC";
                $apikey     = "281c99416f61911e3294fe14ee23a6dee60cddbf10729bff819174ea0430b9fa";
                $recipients = $phone;
                $message    = "Please use this code ".$code. " to activate your Posta account  ";
                $gateway    = new AfricasTalkingGateway($username, $apikey);
                $results = $gateway->sendMessage($recipients, $message);
          
    }
    public function sendAlert($phone, $alertMessage){
                require_once(app_path(). '/functions/AfricasTalkingGateway.php');
                $username   = "LOGIC";
                $apikey     = "281c99416f61911e3294fe14ee23a6dee60cddbf10729bff819174ea0430b9fa";
                $recipients = $phone;
                $message    = $alertMessage;
                $gateway    = new AfricasTalkingGateway($username, $apikey);
                $results = $gateway->sendMessage($recipients, $message);
          
    }
    public function alerts(Request $request){
                $box = $request->input('box');
                $code = $request->input('code');
                $alert = $request->input('alert');
                $message = $request->input('message');
                $date = $request->input('created_at');
                
                if(strlen($box) < 1){
                    return response(array(
                        "Message" => "Please enter the box number",
                        "code" => 209,
                        "status" => "fail",
                     ));
                }else if(strlen($code) < 1){
                    return response(array(
                        "Message" => "Please enter the code",
                        "code" => 209,
                        "status" => "fail",
                     ));
                }else if(strlen($alert) < 1){
                    return response(array(
                        "Message" => "Please enter the alert",
                        "code" => 209,
                        "status" => "fail",
                     ));
                }else if(strlen($message) < 1){
                    return response(array(
                        "Message" => "Please enter the message",
                        "code" => 209,
                        "status" => "fail",
                     ));
                }else if(strlen($date) < 1){
                    return response(array(
                        "Message" => "Please enter the date",
                        "code" => 209,
                        "status" => "fail",
                     ));
                }
                else{
                       $sms = DB::table('persons')->select('Phone')->where(['Box'=>$box, 'CodeNumber'=>$code])->get();
                       if(count($sms) > 0){
                        foreach($sms as $values){
                            $phone = $values->Phone;
                         }
                         $alertMessage = "New alert from Posta. Below is the message: ". $message. " Message sent at: " .$date;
                          $this->sendAlert($phone, $alertMessage);

                       
                       $data = DB::table('alerts')->insert(['Box' => $box, 'Code' => $code, 'Alert' => $alert, 'Message' => $message, 'created_at' =>$date]);
                        if($data){
                        return response(array(
                                "Message" => "The alert was sent successfully",
                                "code" => 200,
                                "status" => "success",
                       ));

                      }else{
                         return response(array(
                                "Message" => "Alert Not sent",
                                "code" => 200,
                                "status" => "success",
                                ));


                }
            }else{
                return response(array(
                    "Message" => "This alert was not sent as this user has not subscribed to recieve notifications",
                    "code" => 200,
                    "status" => "notSubscribed",
                 ));
            }
    }
  }

  public function getAlerts(){
        $data = DB::table('alertTypes')
            ->select('id', 'Type', 'Message')
            ->get();

        if(count($data) > 0){
            foreach($data as $values){
                $Type = $values->Type;
                $Message = $values->Message;
                $id = $values->id;
            }
            return response(array(
                    'alertTypes' =>$data-> toArray()
                ));
        }else{
               return response(array(
                 "No Alert saved yet"
                ));
        }
  }

    public function getMessage(Request $request){
        $alert = $request->input('alert');

        $data = DB::table('alertTypes')
            ->select('Message')
            ->where(['Type' => $alert])
            ->get();

        if(count($data) > 0){
            foreach($data as $values){               
                $Message = $values->Message;
            }
            return response(array(
                   "Message" => $Message
                ));
        }else{
               return response(array(
                 "No Alert saved yet"
                ));
        }
  }
  public function addAlert(Request $request){
            $type = $request->input('type');
            $message = $request->input('message');
            if(count($type) > 0){
                $insert = DB::table('alertTypes')->insert(['Type' => $type, 'Message' => $message]);
                if($insert){
                    return response(array(
                             "Message" => "Alert saved successfully",
                             "code" => 200,
                             "status" => "success",
                        ));
                }else{
                    return response(array(
                             "Message" => "Alert not saved",
                             "code" => 200,
                             "status" => "fail",
                        ));
                }
            }else{
                return response(array(
                             "Message" => "Please enter alert ",
                             "code" => 200,
                             "status" => "fail",
                        ));
            }
  }
  public function editAlert(Request $request){
            $type = $request->input('type');
            $id  = $request->input('id');
            if(count($id) > 0){
               $edit=DB::table('alertTypes')
                    ->where('id', $id)
                    ->update(['Type' => $type]);
                if($edit){
                    return response(array(
                             "Message" => "Alert updated successfully",
                             "code" => 200,
                             "status" => "success",
                        ));
                }else{
                    return response(array(
                             "Message" => "Alert not updated",
                             "code" => 200,
                             "status" => "fail",
                        ));
                }
            }
  }
  public function deleteAlert(Request $request){  
            $alert  = $request->input('alert');
            if(count($alert) > 0){
               $edit=DB::table('alertTypes')
                    ->where('Type', $alert)
                    ->delete();
                if($edit){
                    return response(array(
                             "Message" => "Alert deleted successfully",
                             "code" => 200,
                             "status" => "success",
                        ));
                }else{
                    return response(array(
                             "Message" => "Alert not deleted",
                             "code" => 200,
                             "status" => "fail",
                        ));
                }
            }
  }

  public function usedCredits(Request $request){
    $id = $request->input('id');
    $typeOfSearch = $request->input('typeOfSearch');
    $len = $request->input('len');
    $checkType = "Single";
    $test = strcmp($checkType, $typeOfSearch);
    $getUsedCredits = DB::table('persons')->select('usedCredits')->where('id', $id)->get();
    foreach($getUsedCredits as $credits){
        $usedCreditsBal = $credits->usedCredits;
    }
    if($test == 0){
        $credits = 1;
        $usedCredits = $usedCreditsBal + 1;
    }else{
        $credits = $len;
        $usedCredits = $usedCreditsBal + $credits;
    }
   
    $data = DB::table('persons')
                    ->where('id', $id)
                    ->update(['usedCredits' => $usedCredits]);
                    
    return response(array(
            "Used Credits" => $usedCredits
            ));
  }
  public function getUsedCredits(Request $request){
    $id = $request->input('id');
    $usedCredits = DB::table('persons')
                            ->select('usedCredits', 'credits')
                            ->where('id', $id)
                            ->get();
    foreach ($usedCredits as $credits) {
        $usedCredits = $credits->usedCredits;
        $remCredits = $credits->credits;
    }
    return response(array(
            "usedCredits" => $usedCredits,
            "remCredits" => $remCredits
        ));
  }
}
