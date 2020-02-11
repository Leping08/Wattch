<?php


namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\UserNotificationChannel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;


class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $notification_email_address = $user->notificationEmailAddress();
        $muted_email_notifications = $user->notificationChannelMuted('mail');

        $slack_webhook_url = $user->slackWebhookUrl();
        $muted_slack_notifications = $user->notificationChannelMuted('slack');

        return view('pages.auth.settings.notifications.index', compact('notification_email_address', 'muted_email_notifications', 'slack_webhook_url', 'muted_slack_notifications'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'email',
            'slack_webhook' => 'regex:/^(https:\/\/hooks.slack.com)/', //TODO Add better validation messages here
        ]);

        $user = $request->user();

        //Email update logic
        if ($validatedData['email']) {
            $currentSettingsEmail = $user->notificationEmailAddress();
            if (!($validatedData['email'] === $currentSettingsEmail)) { //The user has changed the email
                Log::info("User Id $user->id is changing notification email from $currentSettingsEmail to ".$validatedData['email']);
                $channel = $user->getNotificationChannel('mail');
                $channel->settings = json_encode([
                    'email' => $validatedData['email']
                ], JSON_PRETTY_PRINT);
                $channel->save();
                Log::info("Email successfully updated for User Id $user->id");
                //TODO Flash message
            } else {
                Log::info("User Id $user->id did not update their email");
                //TODO Flash message
            }
        }

        //Email toggle logic
        if ($request->has('email_toggle')) { //Toggle is on
            $user->toggleSetting('mail', true);
        } else { //Toggle is off
            $user->toggleSetting('mail', false);
        }

        //Slack Webhook logic
        if ($validatedData['slack_webhook']) {
            $currentSlackWebhookUrl = $user->slackWebhookUrl();
            if (!($validatedData['slack_webhook'] === $currentSlackWebhookUrl)) { //The user has changed the email
                Log::info("User Id $user->id is changing their slack webhook url from $currentSlackWebhookUrl to ".$validatedData['slack_webhook']);
                $channel = $user->getNotificationChannel('slack');
                $channel->settings = json_encode([
                    'webhook_url' => $validatedData['slack_webhook']
                ], JSON_PRETTY_PRINT);
                $channel->save();
                Log::info("Slack webhook url successfully updated for User Id $user->id");
                //TODO Flash message
            } else {
                Log::info("User Id $user->id did not update their slack webhook url");
                //TODO Flash message
            }
        }

        //Email toggle logic
        if ($request->has('slack_toggle')) { //Toggle is on
            $user->toggleSetting('slack', true);
        } else { //Toggle is off
            $user->toggleSetting('slack', false);
        }

        return Redirect::back();
    }
}
