<?php

namespace App\Http\Services;

use App\Models\AbyssDemo;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AbyssDemoService extends BaseService {

    const UPLOAD_DIR = 'abyss/';

    /**
     * Set Storage disk
     */
    private $disk;

    /**
     * Class Contructor
     * 
     * @param AbyssDemo $model
     */
    public function __construct(AbyssDemo $model)
    {
        parent::__construct($model);
        $this->disk = Storage::disk('local');
    }

    /**
     * Create new record
     * 
     * @param Request $request
     * @return object
     */
    public function create($request)
    {
        $validator = $this->_validate($request->toArray());

        if($validator->fails()) {
            return response()->json([
                'message' => 'valdation error',
                'errors'  => $validator->errors(),
                'status'  => false
            ], 422);
        }

        $response = $this->model->create($this->_filterRequest($request));

        return $response
            ? response()->json([
                'message' => 'record saved!',
                'data' => $response,
                'status' => true
            ], 200)
            : response()->json([
                'data' => null,
                'message' => 'something went wrong!',
                'status' => false
            ], 500);
    }

    /**
     * Fetch paginated records
     * 
     * @param Request $request
     * @return object
     */
    public function all(Request $request)
    {
        $collection = $this->model->latest()->paginate($request->limit ?? 10);

        return response()->json([
            'status' => true,
            'message' => 'records found!',
            'data' => $collection->items(),
            'pagination' => [
                'totalPages' => $collection->lastPage(),
                'currentPage' => $collection->currentPage(),
                'totalRecords' => $collection->total(),
                'recordsOnCurrentPage' => $collection->count(),
                'recordFrom' => $collection->firstItem(),
                'recordTo' => $collection->lastItem(),
            ],
        ], 200);
    }

    /**
     * Fetch single record w.r.t id
     * 
     * @param $id
     * @return object
     */
    public function getById($id)
    {
        $collection = $this->model->where('id', $id)->first();

        // set temporary url to access file
        $file_url = $this->disk->temporaryUrl(
            $collection->file,
            now()->addMinutes(config('filesystems.url_expiry'))
        );

        return response()->json([
            'status' => true,
            'message' => 'record found!',
            'data' => collect($collection)->put('file_url', $file_url),
        ], 200);
    }

    /**
     * Delete 30 days older records
     * 
     * @return boolean
     */
    public function deleteOlderRecords()
    {
        $to = now()->subDay(1)->format('Y-m-d'); // yesterday
        $from = now()->subDays(31)->format('Y-m-d'); // 30 days before from yesterday
        return $this->model->whereBetween('created_at', [$from, $to])->delete();
    }

    /**
     * Filter incoming request
     * 
     * @param Request $request
     * @return array
     */
    private function _filterRequest(Request $request)
    {
        return [
            'name' => $request->name,
            'type' => $request->type,
            'description' => $request->description,
            'file' => $this->_uploadFile($request->file('file'))
        ];
    }

    /**
     * Upload file to storage
     * 
     * @param UploadedFile $file
     * @return string
     */
    private function _uploadFile(UploadedFile $file)
    {
        $name = $file->hashName();
        $contents = file_get_contents($file);
        $filePath = sprintf("%s/%s", self::UPLOAD_DIR, $name);
        $this->disk->put($filePath, $contents, 'private');
        return $name;
    }

    /**
     * Validate incoming request
     * 
     * @param Array $data
     * @return Validator
     */
    private function _validate(Array $data)
    {
        return Validator::make($data, $this->_rules());
    }

    /**
     * Set rules
     * 
     * @return array
     */
    private function _rules()
    {
        return [
            'name' => 'required|max:50',
            'type' => 'required|integer|between:1,3',
            'file' => 'required|max:5120', // allowed filesize 5MB
            'description' => 'required|max:250'
        ];
    }
}
