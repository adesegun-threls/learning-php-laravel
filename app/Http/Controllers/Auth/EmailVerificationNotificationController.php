<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     * 
     * @OA\Post(
     *     path="/email/verification-notification",
     *     summary="Resend verification email",
     *     description="Send a new email verification notification",
     *     tags={"Authentication"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Verification email sent",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="verification-link-sent")
     *         )
     *     ),
     *     @OA\Response(
     *         response=302,
     *         description="Email already verified, redirects to dashboard"
     *     )
     * )
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended('/dashboard');
        }

        $request->user()->sendEmailVerificationNotification();

        return response()->json(['status' => 'verification-link-sent']);
    }
}
