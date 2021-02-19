--------------------------------------------------------
--  DDL for Package HELPERS
--------------------------------------------------------

CREATE OR REPLACE 
PACKAGE HELPERS AS 

  TYPE t_dataitem_tab IS TABLE OF dataitem.di_id%type index by binary_integer;
  function get_value_from_str (p_string in varchar2, p_search in varchar2, p_cs in boolean default false) return varchar2;
  function get_operation (p_oper in out varchar2) return t_dataitem_tab;

END HELPERS;
/

CREATE OR REPLACE
PACKAGE BODY HELPERS AS

  function get_value_from_str (p_string in varchar2, p_search in varchar2, p_cs in boolean default false) return varchar2  
  as 
  
  v_str varchar2(4000) := p_string;
  v_search varchar2(4000) := p_search;
  v_value varchar2(1000);
  v_pos number(5);
  v_lim number(5);
  begin
    if not p_cs then
      v_str:=upper(p_string);
      v_search:=upper(p_search);
    end if;
    
    v_pos:=instr(v_str, v_search);
    
    if v_pos>0 then
      v_lim:=instr(v_str,';',v_pos);
      if v_lim=0 then
        v_lim:=length(v_str)+1;
      end if;
      
      return substr(v_str, v_pos+length(v_search)+2, v_lim-(v_pos+length(v_search)+2));
    else
      return null;
    end if;
  end get_value_from_str;

  function get_operation (p_oper in out varchar2) return t_dataitem_tab
  as
    v_origins t_dataitem_tab;
    v_oper mapping.mp_operation%type := p_oper;
    v_part varchar2(1000);    
    v_order number(10):=0;
  begin
    while regexp_instr(v_oper, '\[\?(.+?)\?\]')>0 loop
      v_part:=regexp_substr(v_oper, '\[\?(.+?)\?\]');
      v_oper:=replace(v_oper,v_part,'?'||v_order||'?');
      v_part:=regexp_substr(v_part,'\[\d+?\]');
      v_part:=substr(v_part,2,length(v_part)-2);
      v_origins(v_order+1):=v_part;
      v_order:=v_order+1;
    end loop;
    p_oper:=v_oper;
    return v_origins;
  end get_operation;

END HELPERS;
/