import json
import os

with open('build/asset-manifest.json') as data_file:    
    data = json.load(data_file)

print("Moving building files")
print(data['main.js'])
print(data['main.css'])

os.rename( 'build/' + data['main.js'], 'build/static/js/bootcamp_bundle.js')
os.rename( 'build/' + data['main.css'], 'build/static/css/bootcamp_bundle.css')