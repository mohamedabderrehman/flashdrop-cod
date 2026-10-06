"""Synthetic HTTP acceptance checks; start PHP in DEMO_MODE=1 first."""
import json,urllib.request,urllib.error,uuid,os
from pathlib import Path
root=Path(__file__).resolve().parents[1]
results=[]
def call(url,data,headers=None):
 if isinstance(data,dict): data=json.dumps(data,ensure_ascii=False).encode()
 request=urllib.request.Request(url,data=data,headers=headers or {'Content-Type':'application/json'})
 try:
  with urllib.request.urlopen(request,timeout=10) as response:return response.status,json.load(response)
 except urllib.error.HTTPError as error:return error.code,json.load(error)
opts=json.loads((root/'api/options.json').read_text(encoding='utf-8'))
order={'fullname':'Synthetic Customer','wilaya':opts['wilaya'][0],'baladia':'Synthetic municipality','phone':'0550000000','color':opts['color'][0],'size':opts['size'][0],'delivery':opts['delivery'][0],'quantity':1,'address':''}
url=os.getenv('DEMO_API_URL','http://127.0.0.1:8084')+'/api/order.php';key=str(uuid.uuid4());h={'Content-Type':'application/json','Idempotency-Key':key}
code,body=call(url,order,h);assert code==200 and body['success'] and body['demo'];receipt=body['order_id'];results.append('Flashdrop valid synthetic order: passed')
code,body=call(url,order,h);assert code==200 and body['order_id']==receipt;results.append('Flashdrop repeated key returns same receipt: passed')
code,body=call(url,dict(order,quantity=2),h);assert code==409;results.append('Flashdrop changed payload/key conflict: passed')
for field,value in [('phone','invalid'),('quantity',0),('size','unsupported'),('wilaya','unsupported'),('color','unsupported'),('delivery','unsupported')]:
 code,_=call(url,dict(order,**{field:value}),dict(h,**{'Idempotency-Key':str(uuid.uuid4())}));assert code==422,field
results.append('Flashdrop server validation of phone/quantity/options: passed')
code,_=call(url,order,dict(h,Origin='https://unrelated.example'));assert code==403;results.append('Flashdrop foreign-origin rejection: passed')

print('\n'.join(results))
