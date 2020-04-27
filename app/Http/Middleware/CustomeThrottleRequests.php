<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponser;
use Closure;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Routing\Middleware\ThrottleRequests;

class CustomeThrottleRequests extends ThrottleRequests
{
    // use ApiResponser;
    // /**
    //  * Create a 'too many attempts' exception.
    //  *
    //  * @param  string  $key
    //  * @param  int  $maxAttempts
    //  * @return \Illuminate\Http\Exceptions\ThrottleRequestsException
    //  */
    // protected function buildException($key, $maxAttempts)
    // {
    //     $response = $this->errorResponse('Too Many Attempts.', 429);
    //     $retryAfter = $this->getTimeUntilNextRetry($key);

    //     $headers = $this->getHeaders(
    //         $maxAttempts,
    //         $this->calculateRemainingAttempts($key, $maxAttempts, $retryAfter),
    //         $retryAfter
    //     );

    //     return new ThrottleRequestsException(
    //         'Too Many Attempts.',
    //         null,
    //         $headers
    //     );
    // }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}
