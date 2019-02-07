<?php
namespace LayoutUI\Http\Controllers;

use LayoutUI\Core;

class AssetsController extends Controller
{
    /**
     * Devolve um arquivo css para o frontend.
     *
     * @param  string $file Nome do arquivo na pasta appmod/public/css
     * @return Response
     */
    public function css($file)
    {
        return $this->response('css/themes', $file);
    }

    /**
     * Devolve um arquivo de tema css para o frontend.
     *
     * @param  string $file Nome do arquivo na pasta appmod/public/css/themes
     * @return Response
     */
    public function theme($file)
    {
        return $this->response('css/themes', $file);
    }

    /**
     * Devolve um arquivo js para o frontend.
     *
     * @param  string $file Nome do arquivo na pasta appmod/public/js
     * @return Response
     */
    public function js($file)
    {
        return $this->response('js', $file);
    }

    /**
     * Devolve uma imagem para o frontend.
     *
     * @param  string $file Nome do arquivo na pasta appmod/public/imgs
     * @return Response
     */
    public function img($file)
    {
        return $this->response('imgs', $file);
    }

    /**
     * Devolve uma webfont para o frontend.
     *
     * @param  string $package Ex: fontawesome5
     * @param  string $file Nome do arquivo na pasta appmod/public/fonts/$package/
     * @return Response
     */
    public function font($package, $file)
    {
        return response()->file(Core::modPath("public/fonts/$package/$file"), [
            'Content-Type' => 'application/octet-stream'
        ]);
    }

    /**
     * Devolve a resposta de acordo com o tipo de arquivo.
     *
     * @param  string $resource_dir
     * @param  string $filename
     * @return Response
     */
    private function response($resource_dir, $filename)
    {
        if ($resource_dir == 'js') {
            // JavaScript (ECMAScript)
            $mime = 'application/javascript';

        } elseif($resource_dir == 'css/themes' || $resource_dir == 'css') {
            // Cascading Style Sheets (CSS)
            $mime = 'text/css';

        } else {

            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            switch($extension) {
                case 'webp':
                    // WEBP image
                    $mime = 'image/webp';
                    break;

                case 'png':
                    // Portable Network Graphics
                    $mime = 'image/png';
                    break;

                case 'jpg':
                    // JPEG images
                    $mime = 'image/jpeg';
                    break;

                case 'gif':
                    // Graphics Interchange Format (GIF)
                    $mime = 'image/gif';
                    break;
            }
        }

        return response()->file(Core::modPath("public/{$resource_dir}/{$filename}"), [
            'Content-Type' => $mime
        ]);
    }
}
