$(document).ready(function() {
    $('.toggle-status').on('change', function() {
        let categoryId = $(this).data('id');
        let status = $(this).prop('checked') ? 1 : 0;
        let label = $('#status-label-' + categoryId);

        $.ajax({
            url: "{{route('club.category_management.change-status')}}", 
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: categoryId,
                status: status
            },
            success: function(response) {
                if (status === 1) {
                    label.text('Active')
                         .removeClass('bg-secondary-subtle text-secondary')
                         .addClass('bg-success-subtle text-success');
                } else {
                    label.text('Inactive')
                         .removeClass('bg-success-subtle text-success')
                         .addClass('bg-secondary-subtle text-secondary');
                }
            },
            error: function() {
                alert("Error updating status. Please try again.");
                $(this).prop('checked', !$(this).prop('checked'));
            }
        });
    });
});








 public function changeStatus(Request $request)
    {
        $category = Category::find($request->id);
        if ($category) {
            $category->status = $request->status;
            $category->save();

            return response()->json(['success' => 'Status changed successfully.']);
        }
        return response()->json(['error' => 'Category not found.'], 404);
    }

    public function show(){
        $categories = Category::all();
    return view('club.category_management.show_category',compact('categories'));

    }

    public function destroy($id){
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect("club/category_management/show_category");
        

    }

     public function edit_category_index($id){
         $category = Category::findOrFail($id);
          return view('club.category_management.edit_category_index',compact('category'));
    }

    public function update(Request $request, $id){ 
        $category = Category::findOrFail($id);
          $category->name = $request->name;
          
          $category->save();
          return redirect('/club/category_management/show_category'); 


    }
