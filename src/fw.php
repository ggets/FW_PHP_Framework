<?php
/**
 * Ultimate Universal Web Project Framework
 * @author  hkr GG
 * @version 0.0.26
 * @require PHP >=7.3.0
 * @written PHP ==7.4.0
 * @rev     12.06.2021
 */
namespace dreamflame\fwx{
	class fw{
		public static function obj($o=null){
			return new class($o){
				public function __isfwobj(){}
				public function __call($m,$a){
					if(isset($this->$m))return call_user_func_array($this->$m,$a);
					else $this->m=$m;
				}
				public function __construct($o=null){
					if(isset($o)){
						$o=(object)$o;
						if(!property_exists($o,'__p'))foreach($o as $k=>$v)$this->$k=$v;
						elseif(property_exists($o,'__v'))foreach($o->__p as $v)$this->$v=$o->__v;
						else foreach($o->__p as $k=>$v)$this->$k=$v;
					}
				}
				public function __dump(){
					$a=array();
					foreach($this as $k=>$v)if(property_exists($this,$k))$a[$k]=$v;
					return $a;
				}
				public function new($o=array()){
					$o=(object)$o;
					$n=clone $this;
					foreach($o as $k=>$v)$n->$k=$v;
					return $n;
				}
				public function isset($p=null){
					return (($p===null)?null:property_exists($this,$p));
				}
			};
		}
		public static function e($s){echo($s);}
		public static function v($s){var_dump($s);}
		public static function vd($s){var_dump($s);die;}
		public static function ve($s=null,$r=true){return var_export($s,$r);}
		public static function n($m=null){
			global $fw;
			if(isset($fw))$fw->err(array('m'=>var_export($m,true)));
		}
		public static function elog($m=null){
			global $fw;
			if(isset($fw))$fw->err(array("m"=>$m,"o"=>"log"));
		}
		/* is_fwobj($o) */
		public static function is_fwobj(&$o=null){return (isset($o)&&method_exists($o,'__isfwobj'));}
		public static function pb($o=0,$l=0){debug_print_backtrace($o,$l);}
		public static function backtrace_namespace(){
			$t=array();//trace
			$fns=array_map(
				function($v){
					return $v['function'];
				},
				debug_backtrace()
			);
			foreach($fns as $fn){
				$f=new \ReflectionFunction($fn);
				$t[]=array(
					'function'=>$fn,
					'namespace'=>$f->getNamespaceName()
				);
			}
			return $t;
		}
	}
}
