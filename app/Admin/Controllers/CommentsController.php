<?php

namespace App\Admin\Controllers;

use App\Models\Comment;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CommentsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Comment';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Comment());

        $grid->column('id', __('Id'));
        $grid->column('user_id', __('所属用户'));
        $grid->column('dynamic_id', __('所属游记'));
        $grid->column('video_id', __('所属短视频'));
        $grid->column('thumb_count', __('点赞数'));
        $grid->column('type', __('类型'))->display(function ($type) {
            switch ($type){
                case "dynamic":return "游记";
                case "video":return "短视频";
                default:return "未知类型";
            }
        });
        $grid->column('content', __('内容'));
        $grid->column('status', __('审核状态'))->display(function ($status) {
            switch ($status){
                case 1:return "通过";
                case 2:return "禁止";
                default:return "待审核";
            }
        });
        $grid->column('created_at', __('创建时间'));
        $grid->column('created_at', __('更新时间'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Comment::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('所属用户'));
        $show->field('dynamic_id', __('所属动态'));
        $show->field('video_id', __('所属短视频'));
        $show->field('thumb_count', __('点赞数'));
        $show->field('type', __('Type'));
        $show->field('content', __('内容'));
        $show->field('status', __('状态'));
        $show->field('created_at', __('创建时间'));
        $show->field('updated_at', __('更新时间'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Comment());

        $form->number('user_id', __('所属用户'));
        $form->number('dynamic_id', __('所属动态'));
        $form->number('video_id', __('所属短视频'));
        $form->number('thumb_count', __('点赞数'));
        $form->text('type', __('类型'));
        $form->textarea('content', __('内容'));
        $form->radio('status', '状态')->options(['0' => '审核', '1'=> '通过', '2'=> '禁止'])->default('1');

        return $form;
    }
}
