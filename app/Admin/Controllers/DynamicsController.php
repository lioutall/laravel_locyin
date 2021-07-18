<?php

namespace App\Admin\Controllers;

use App\Models\Dynamic;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class DynamicsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Dynamic';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Dynamic());

        $grid->column('id', __('Id'));
        $grid->column('user_id', __('所属用户'));
        $grid->column('thumb_count', __('点赞数量'));
        $grid->column('collect_count', __('收藏数量'));
        $grid->column('comment_count', __('评论数量'));
        $grid->column('content', __('内容摘要'))->display(function ($string) {
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
        $show = new Show(Dynamic::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('所属用户'));
        $show->field('thumb_count', __('点赞数'));
        $show->field('collect_count', __('收藏数'));
        $show->field('comment_count', __('评论数'));
        $show->field('content', __('内容'));
        $show->field('status', __('状态'));
        $show->field('location', __('位置'));
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
        $form = new Form(new Dynamic());

        $form->number('user_id', __('所属用户'))->rules('required');;
        $form->number('thumb_count', __('点赞数'))->default('0');
        $form->number('collect_count', __('收藏数'))->default('0');
        $form->number('comment_count', __('评论数'))->default('0');
        $form->textarea('content', __('内容'))->rules('required');;
        $form->radio('status', '状态')->options(['0' => '审核', '1'=> '通过', '2'=> '禁止'])->default('1');
        $form->text('location', __('位置'))->rules('required');;

        return $form;
    }
}
