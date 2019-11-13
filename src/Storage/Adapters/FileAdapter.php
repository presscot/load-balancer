<?php
/**
 * Created by PhpStorm.
 * User: pprusek
 * Date: 12.11.19
 * Time: 19:02
 */

namespace Press\LoadBalancer\Storage\Adapters;

/**
 * Class FileAdapter
 * @package Press\LoadBalancer\Storage\Adapters
 */
class FileAdapter implements StorageAdapterInterface
{
    /** @var string $location */
    private $location;

    /**
     * FileAdapter constructor.
     * @param string $location
     */
    public function __construct(string $location)
    {
        $this->location = $location;
    }

    /**
     * @param string $key
     * @param string $value
     * @param null|string $index
     */
    public function add(string $key, string $value, ?string $index = null): void
    {
        if(empty($index)){
            $index = time();
        }

        if( !is_dir( "{$this->location}/{$key}" ) ){
            mkdir("{$this->location}/{$key}");
        }

        $this->set("{$key}/{$index}", $value);
    }

    /**
     * @param string $key
     * @param string $value
     */
    public function set(string $key, string $value): void
    {
        $handle = fopen("{$this->location}/{$key}", "a");
        fwrite($handle, "{$value}");
        fclose($handle);
    }

    /**
     * @param string $key
     * @return array|bool|null|string
     */
    public function get(string $key)
    {

        if( is_dir( "{$this->location}/{$key}" ) ){
            $arr = [];
            $files = glob("{$this->location}/{$key}/*");
            foreach($files as $file){
                if(is_file($file)){
                    $arr[basename($file)] = $this->get($file);
                }
            }
            return $arr;
        }elseif(true === file_exists("{$this->location}/{$key}")) {
            $handle = fopen("{$this->location}/{$key}", "r");
            $value = fread($handle, filesize("{$this->location}/{$key}"));
            fclose($handle);
            return $value;
        }
        return null;
    }

    /**
     * @param string $key
     */
    public function remove(string $key): void
    {
        if( is_dir( "{$this->location}/{$key}" ) ){
            $files = glob("{$this->location}/{$key}/*");
            foreach($files as $file){
                $this->remove("{$key}/" . basename($file));
            }
        }elseif(true === file_exists("{$this->location}/{$key}")) {
            unlink("{$this->location}/{$key}");
        }
    }

    /**
     * @param string $key
     * @param $index
     */
    public function removeElement(string $key, $index ): void{

        if( is_dir( "{$this->location}/{$key}" ) ){
            if( is_file( "{$this->location}/{$key}/{$index}" ) ){
                $this->remove("{$key}/{$index}");
            }
        }
    }

    /**
     *
     */
    public function clear(): void
    {
        $files = glob("{$this->location}/*");
        foreach($files as $file){
            if(is_file($file))
                unlink($file);
        }
    }
}