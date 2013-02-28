<?php
/**
 * Plugin Name: Moodle Course List with login
 * Description: Enter your Moodle username to display your Moodle courses.  You can also show a login form.
 * Version: 1.0
 * Author: Chris Kenniburg
 * Author URI: http://dearbornschools.org
 */


add_action( 'widgets_init', 'ilearn_courses' );


function ilearn_courses() {
	register_widget( 'iLearn_Courses' );
}

class iLearn_Courses extends WP_Widget {

	function iLearn_Courses() {
		$widget_ops = array( 'classname' => 'moodlecourses', 'description' => __('Display a list of your Moodle courses. Enter a Moodle Username to display a list of courses you are a teacher role.', 'moodlecourses') );
		
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'moodlecourses-widget' );
		
		$this->WP_Widget( 'moodlecourses-widget', __('Moodle Course List', 'moodlecourses'), $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) {
		extract( $args );

//CHANGE yourmoodlesiteurl.com to your Moodle site URL.  
		$title = apply_filters('widget_title', $instance['title'] );
		$name = $instance['name'];
		$show_login = isset( $instance['show_login'] ) ? $instance['show_login'] : false;
		$login = ('<br><p><strong>Moodle Login</strong></p><form id="form" name="form" method="post" action="http://yourmoodlesiteurl.com/login/index.php">
		Username:<input type="text" name="username" /><br>Password:<input type="password" name="password" /><br /><br />
		<input type="submit" name="" value="Log In to Moodle" /></form>');
	
		echo $before_widget;

		if ( $title )
			echo $before_title . $title . $after_title;
//CHANGE localhost, MySQLusername, MYSQLpassword to an account that has read only access to your Moodle database.  Your Moodle website may not be on the same server as Wordpress in which case you will need to change localhost to an IP address of the server that contains your Moodle database.  This may require additional setup on your Moodle server.
		$con = mysql_connect("localhost","MySQLusername","MYSQLpassword");
		if (!$con) {
		die('Could not connect: ' . mysql_error());
		}
		mysql_select_db("moodle", $con);

		$username = $instance['name'];

		$username = mysql_real_escape_string($username);

		$query_course_list = "SELECT c.id AS courseid, c.fullname
		FROM mdl_role_assignments ra
		JOIN mdl_user u ON u.id = ra.userid
		JOIN mdl_role r ON r.id = ra.roleid
		JOIN mdl_context cxt ON cxt.id = ra.contextid
		JOIN mdl_course c ON c.id = cxt.instanceid

		WHERE ra.userid = u.id

		AND ra.contextid = cxt.id AND cxt.contextlevel =50 AND cxt.instanceid = c.id
		AND roleid = 3 AND u.username = '$username'
		ORDER BY c.fullname ";


		$courses = mysql_query($query_course_list);


		$output = '<ul>';

		while ($course = mysql_fetch_object($courses)){
// CHANGE yourmoodlesiteurl.com to your Moodle URL
		$output .= '<li>';
		$output .= '<a href = "http://yourmoodlesiteurl.com/course/view.php?id='.$course->courseid.'">';
		$output .= $course->fullname;
		$output .='</a>';
		$output .='</li>';
	}
		$output .= '</ul>';

		echo $output;

		if ( $show_login )
		printf( $login );
			
		echo $after_widget;
	}

	 
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['name'] = strip_tags( $new_instance['name'] );
		$instance['show_login'] = $new_instance['show_login'];

		return $instance;
	}

	
	function form( $instance ) {

		$defaults = array( 'title' => __('My Moodle Courses', 'moodlecourses'), 'name' => __('admin', 'moodlecourses'), 'show_login' => false);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title of Widget:', 'moodlecourses'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'name' ); ?>"><?php _e('Enter a Moodle Username:', 'moodlecourses'); ?></label>
			<input id="<?php echo $this->get_field_id( 'name' ); ?>" name="<?php echo $this->get_field_name( 'name' ); ?>" value="<?php echo $instance['name']; ?>" style="width:100%;" />
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( isset( $instance['show_login']), true ); ?> id="<?php echo $this->get_field_id( 'show_login' ); ?>" name="<?php echo $this->get_field_name( 'show_login' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'show_login' ); ?>"><?php _e('Display Moodle login form?', 'moodlecourses'); ?></label>
            
		</p>
		

	<?php
	}
}

?>