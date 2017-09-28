<?php namespace Economics\InventoryLocation;

use Economics\ClientInterface as Client;
use Economics\Unit\Unit;

class InventoryLocation {

    /**
     * Client Connection
     * @var devdk\Economics\Client
     */
    protected $client;

    /**
     * Instance of Client
     * @var devdk\Economics\Client
     */
    protected $client_raw;

    /**
     * Construct class and set dependencies
     * @param devdk\Economics\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client     = $client->getClient();
        $this->client_raw = $client;
    }

    /**
     * Get InventoryLocation handle by inventory location number
     * @param  integer $no
     * @return object
     */
    public function getHandle($no)
    {
        if( is_object($no) AND isset($no->Number) ) return $no;

        return $this->client
            ->InventoryLocation_FindByNumber(array('number'=>$no))
            ->InventoryLocation_FindByNumberResult;
    }

    /**
     * Get InventoryLocation data from handle
     * @param  object $handle
     * @return object
     */
    public function getDataFromHandle($handle)
    {
        return $this->client
            ->InventoryLocation_GetData($handle)
            ->InventoryLocation_GetDataResult;
    }

    /**
     * Get InventoryLocations data from handles
     * @param  object $handles
     * @return object
     */
    public function getArrayFromHandles($handles)
    {
        return $this->client
            ->InventoryLocation_GetDataArray(array('entityHandles'=>array('InventoryLocationHandle'=>$handles)))
            ->InventoryLocation_GetDataArrayResult
            ->InventoryLocationData;
    }

    public function get($no)
    {
        $handle = $this->getHandle($no);

        return $this->getArrayFromHandles($handle);
    }

    public function all()
    {
        $handles = $this->client
            ->InventoryLocation_GetAll()
            ->InventoryLocation_GetAllResult
            ->InventoryLocationHandle;

        return $this->getArrayFromHandles($handles);
    }

    /**
     * Find an inventorys location by it's name.
     * The name has to be an exact match in
     * order to get any returns. Unfortunately
     * this method can't be used very well as a
     * search function.
     *
     * @param  string $query
     * @return null|stdClass
     */
    public function find($query)
    {
        $handle = $this->client
            ->InventoryLocation_FindByName(array('name'=>$query))
            ->InventoryLocation_FindByNameResult;

        if( ! isset($handle->InventoryLocation_FindByNameResult) )
            return null;

        return $this->getDataFromHandle($handles->InventoryLocationHandle);
    }

}
