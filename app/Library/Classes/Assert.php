<?php


namespace App\Library\Classes;


use GuzzleHttp\Client;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Http\Response;

class Assert
{
    /**
     * Calling this looks like Assertion::run('https://www.google.com/', 'assertSee', ['about'])
     *
     * assertSee(string $value)
     * assertDontSee(string $value)
     * assertStatus(string $value)
     * assertJsonFragment(array $data)
     * assertJsonMissing(array $data)
     * assertRedirect(string $uri)
     * assertSuccessful()                        200
     * assertOk()                                200
     * assertUnauthorized()                      401
     * assertNotFound()                          404
     *
     * The assertion methods come from the laravel testing docs
     * https://laravel.com/docs/master/http-tests
     *
     * @param string $route
     * @param string $assertionMethod
     * @param array $parameters
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function run(string $route, string $assertionMethod, array $parameters = [])
    {
        try {
            $client = resolve('HttpClient');
            $res = $client->request('GET', $route);
        } catch (\Exception $exception) {
            return [
                'status' => false,
                'error_message' => $exception->getMessage() ?? 'Something went wrong'
            ];
        }

        $res = Response::create($res->getBody(), $res->getStatusCode(), $res->getHeaders());

        $response = new TestResponse($res);

        try {
            call_user_func_array([$response, $assertionMethod], $parameters);
            return [
                'status' => true,
                'error_message' => null
            ];
        } catch (\Exception $exception) {
            return [
                'status' => false,
                'error_message' => $exception->getMessage() ?? 'Something went wrong'
            ];
        }
    }
}
