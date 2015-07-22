using System;
using System.IO;
using System.Net;
using System.Text;
using System.Threading;
using System.Windows.Forms;
using System.Collections.Generic;
using System.Security.Cryptography;
using System.Runtime.Serialization;
using System.Runtime.Serialization.Json;

namespace UpdaterModule
{
    public class Updater
    {
        public bool UpdateAvailable
        {
            get
            {
                return _newFile.Hash != _thisHash;
            }
        }

        private string _thisHash;
        private string _websiteUrl;
        private string _filePath;

        private ClientFile _newFile;

        public Updater(string url)
        {
            if (string.IsNullOrWhiteSpace(url))
                throw new Exception("Url cannot be null or whitespace");

            if (!url.EndsWith("?cmd=last"))
                url += "?cmd=last";

            _websiteUrl = url;

            InitializeModule();
        }

        private  void InitializeModule()
        {
            using (var wc = new WebClient())
            {
                string response = wc.DownloadString(_websiteUrl);
                _newFile = Deserialize<ClientFile>(response);
            }

            _thisHash = ComputeSha1Hash();
        }

        public void Refresh()
        {
           InitializeModule();
        }

        public bool AgreesToUpdate()
        {
            var response = MessageBox.Show("Update available, do you want to download it?", "Prompt", MessageBoxButtons.YesNo);

            if (response != DialogResult.Yes)
                return false;

            using (var ofd = new SaveFileDialog() {FileName = _newFile.Name, Filter = "Executable(.*exe)|*.exe" })
            {
                if (ofd.ShowDialog() == DialogResult.OK)
                {
                    _filePath = ofd.FileName;

                    return true;
                }               
            }

            return false;
        }

        public void DownloadUpdate()
        {
            if (_filePath != null)
            {
                using (var wc = new WebClient())
                {
                    wc.DownloadFile(_newFile.DownloadLink, _filePath);
                }
            }
        }

        private string ComputeSha1Hash()
        {
            byte[] file = File.ReadAllBytes(Application.ExecutablePath);

            using (var sha = new SHA1Managed())
            {
                byte[] hash = sha.ComputeHash(file);
                return BitConverter.ToString(hash).Replace("-", "").ToLower();
            }
        }

        private T Deserialize<T>(string json)
        {
            //By PatPositron
            var s = new DataContractJsonSerializer(typeof(T));
            using (var ms = new MemoryStream(Encoding.UTF8.GetBytes(json)))
            {
                return (T)s.ReadObject(ms);
            }
        }
    }
}