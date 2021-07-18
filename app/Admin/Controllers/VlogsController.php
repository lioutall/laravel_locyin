<?php

namespace App\Admin\Controllers;

use App\Models\Vlog;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class VlogsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Vlog';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Vlog());

        $grid->column('id', __('Id'));
        $grid->column('user_id', __('所属用户'));
        $grid->column('thumb_count', __('点赞数'));
        $grid->column('collect_count', __('收藏数'));
        $grid->column('comment_count', __('评论数'));
        $grid->column('illustration', __('说明摘要'))->display(function ($string) {
            $charset = 'UTF-8';
            $length = 50;
            /*$string = 'Hai to yoo! I like yoo soo!';*/
            if(mb_strlen($string, $charset) > $length) {
                $string = mb_substr($string, 0, $length - 3, $charset) . '...';
            }
            return $string;
        });
        $grid->column('status', __('审核状态'))->display(function ($status) {
            switch ($status){
                case 1:return "通过";
                case 2:return "禁止";
                default:return "待审核";
            }
        });
        $grid->column('location', __('位置'));
        $grid->column('title', __('标题'));
        $grid->column('created_at', __('创建时间'));
        $grid->column('updated_at', __('更新时间'));

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
        $show = new Show(Vlog::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('User id'));
        $show->field('thumb_count', __('Thumb count'));
        $show->field('collect_count', __('Collect count'));
        $show->field('comment_count', __('Comment count'));
        $show->field('illustration', __('Illustration'));
        $show->field('status', __('Status'));
        $show->field('location', __('Location'));
        $show->field('title', __('Title'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Vlog());

        $form->number('user_id', __('User id'));
        $form->number('thumb_count', __('Thumb count'));
        $form->number('collect_count', __('Collect count'));
        $form->number('comment_count', __('Comment count'));
        $form->textarea('illustration', __('Illustration'));
        $form->number('status', __('Status'));
        $form->text('location', __('Location'));
        $form->text('title', __('Title'));

        return $form;
    }
}
