<?php

namespace Core\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Core\Models\Media as Model;
use Core\Models\TemporaryFile;
use Illuminate\Database\QueryException;
use Storage;

class Media extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $media = Model::orderBy('id', 'DESC')->paginate(10);
        return view("panel::media.index", ["media" => $media]);
    }

    /**
     * Display create form for the resource.
     *
     * @return Response
     */
    public function create()
    {
        return view("panel::media.create");
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'files' => 'required',
            ]);

            foreach (json_decode($request->input('files')) as $file) {
                $media = new Model();

                // $temporaryFile = TemporaryFile::where('folder', $request->file)->first();
                $temporaryFile = TemporaryFile::where('folder', $file)->first();

                if (!$temporaryFile) {
                    continue;
                    /*
                    return redirect()
                        ->route("panel.media.create")
                        ->with("form_error", trans("general.error"));
                     */
                }

                $newFilename = now()->timestamp . $temporaryFile->filename;

                rename(
                    storage_path('app/public/uploads/tmp/' . $file . '/' . $temporaryFile->filename),
                    // 'uploads/' . $newFilename
                    public_path("uploads") . '/' . $newFilename
                );

                $media->name = $temporaryFile->filename;
                // $media->path = public_path("uploads") . $newFilename;
                $media->path = 'uploads/' . $newFilename;
                $media->save();

                // rmdir(storage_path('app/public/uploads/tmp/' . $request->file));
                rmdir(storage_path('app/public/uploads/tmp/' . $file));
                $temporaryFile->delete();
            }

            return redirect()
                ->route("panel.media.index")
                ->with("message_success", "File uploaded");
        } catch (QueryException $e) {
            return redirect()
                ->route("panel.media.create")
                ->with("form_error", trans("general.error"));
        }

    }

    /**
     * Upload and save the resource.
     *
     * @return Response
     */
    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName();
            $folder = uniqid() . '-' . now()->timestamp;
            $file->storeAs('public/uploads/tmp/' . $folder, $filename);

            TemporaryFile::create([
                'folder' => $folder,
                'filename' => $filename
            ]);

            return $folder;
        }

        return '';
    }

    /**
     * Display edit form for the resource.
     *
     * @return Response
     */
    public function edit($id)
    {
        $media = Model::where("id", "=", $id)->first();

        if (!$media) {
            return redirect()
                ->route("panel.media.index")
                ->with(
                    "message_error",
                    trans("general.not_found", [
                        "type" => trans("general.media"),
                    ])
                );
        }

        return view("panel::media.edit", ["media" => $media]);
    }

    /**
     * Upload and save the resource.
     *
     * @return Response
     */
    public function update(Request $request)
    {
        $media = Model::where("id", "=", $request->input("id"))->first();

        if (!$media) {
            return redirect()
                ->route("panel.media.edit", ["id" => $request->input("id")])
                ->with("form_error", "Media not updated.");
        }

        $media->update($request->all());

        return redirect()
            ->route("panel.media.edit", ["id" => $request->input("id")])
            ->with("form_success", "Media updated.");
    }

    /**
     * Delete resource.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function delete($id)
    {
        $media = Model::where("id", "=", $id)->first();

        if (!$media) {
            return redirect()
                ->route("panel.media.index")
                ->with(
                    "message_error",
                    trans("general.not_found", [
                        "type" => trans("general.media"),
                    ])
                );
        }

        // delete file from storage
        unlink(public_path($media->path));

        $media->delete();

        return redirect()
            ->route("panel.media.index")
            ->with("message_success", "Media deleted successfully.");
    }
}
