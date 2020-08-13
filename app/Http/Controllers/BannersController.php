<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use RealRashid\SweetAlert\Facades\Alert;
use Image;
use App\Banner;

class BannersController extends Controller
{
    public function banners()
    {
        $bannerDetails = Banner::get();
        return view('admin.banner.banners')->with(compact('bannerDetails'));
    }

    public function addBanner(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            $banner = new Banner;
            $banner->name = $data['banner_name'];
            $banner->text_style = $data['text_style'];
            $banner->sort_order = $data['sort_order'];
            $banner->content = $data['banner_content'];
            $banner->link = $data['link'];
            
        //upload image
        if($request->hasfile('image')){
            echo $img_tmp = $request->file('image');
            if($img_tmp->isValid()){

            
            //image path code
            $extension = $img_tmp->getClientOriginalExtension();
            $filename = rand(111,99999).'.'.$extension;
            $img_path = 'uploads/banners/'.$filename;

            //Image resize
            Image::make($img_tmp)->resize(500,500)->save($img_path);
            $banner->image = $filename;
            }
        }
          $banner->save();
          return redirect('admin/banners')->with('flash_message_success','Banners has been added successfully!!');
        }
        return view('admin.banner.add_banner');
    }

    public function editBanner(Request $request,$id=null)
    {
        if($request->isMethod('post')){
            $data = $request->all();
              //upload image
              if($request->hasfile('image')){
                echo $img_tmp = $request->file('image');
                if($img_tmp->isValid()){

                
                //image path code
                $extension = $image_tmp->getClientOriginalExtension();
                $filename = rand(111,99999).'.'.$extension;
                $banner_path = 'uploads/banners/'.$filename;

                //Image resize
                Image::make($img_tmp)->resize(500,500)->save($banner_path);
                }
            } elseif(!empty($data['current_image'])){
                $filename = $data['current_image'];
            }else{
                $filename = '';
            }
            Banner::where(['id'=>$id])->update(['name'=>$data['banner_name'],'text_style'=>$data['text_style'],'content'=>$data['banner_content'],'link'=>$data['link'],
            'sort_order'=>$data['sort_order'],'image'=>$filename]);
            return redirect('/admin/banners/')->with('flash_message_success','Banner has been edited successfully');
        }
        $bannerDetails = Banner::where(['id'=>$id])->first();
        return view('admin.banner.edit_banner')->with(compact('bannerDetails'));
    }

    public function deleteBanner($id=null)
    {
        Banner::where(['id'=>$id])->delete();
        Alert::success('Deleted Successfully','Success Message');
        return redirect()->back()->with('flash_message_error','Banner Deleted');
    }

    public function updateStatus(Request $request,$id=null)
    {
        $data = $request->all();
        Banner::where('id',$data['id'])->update(['status'=>$data['status']]);
    }
}
