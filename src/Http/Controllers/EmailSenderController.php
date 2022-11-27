<?php

namespace Lanos\SendgridTenancy\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class EmailSenderController extends Controller
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function getEmailSenders(Request $request): mixed
    {
        return tenant()->email_senders()->get();
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function checkEmailStatus(Request $request, $id){

        $email = tenant()->email_senders()->find($id);

        if($email){

            $sg = new \SendGrid(config('sgten.sg_key'));

            try {
                $response = $sg->client->whitelabel()->domains()->_($email->sendgrid_id)->validate()->post();
                $data = json_decode($response->body());

                if($data->valid){
                    $email->update(["valid" => true]);
                }

                return tenant()->email_senders()->get();

            } catch (Exception $ex) {
                return response()->json((object)[
                    "Error" => "Error connecting to Sendgrid",
                    "Message" => $ex->getMessage()
                ], 400);
            }

        }else{
            return response()->json((object)[
                "Error" => "The email couldn't be found"
            ], 400);
        }

    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse|void
     */
    public function deleteEmail(Request $request, $id){

        $email = tenant()->email_senders()->find($id);

        if($email){

            // TODO DELETE FUNCTION

        }else{
            return response()->json((object)[
                "Error" => "The domain couldn't be found"
            ], 400);
        }

    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function createEmailSender(Request $request){

        $sg = new \SendGrid(config('sgten.sg_key'));

        // CHECK EMAIL PROVIDED IS VALID AND DOESNT ALREADY EXIST

        $request->validate([
            'domain' => ['required', 'string', Rule::unique('central.email_authentication'), 'regex:/^(?!:\/\/)(?=.{1,255}$)((.{1,63}\.){1,127}(?![0-9]*$)[a-z0-9-]+\.?)$/i'],
        ]);

        $request_body = json_decode('{
            "domain": "'.$request->domain.'",
            "custom_spf": false,
            "default": false,
            "automatic_security": true
        }');

        try {
            $addSendgrid = $sg->client->whitelabel()->domains()->post($request_body);

            $data = json_decode($addSendgrid->body());

            tenant()->createEmailSender([
                "domain" => $request->domain,
                "dkim_setup" => $data,
                "sendgrid_id" => $data->id
            ]);

            return tenant()->email_senders()->get();

        } catch (Exception $ex) {
            return response()->json((object)[
                "Error" => $ex->getMessage()
            ], 500);
        }

    }


}